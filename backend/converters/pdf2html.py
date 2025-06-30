import argparse
import io
import os
import json

from collections import Counter
from datetime import datetime
from pathlib import Path

from PIL import Image
import fitz
import pandas as pd

IMAGES_DIR = "images"
FONTS_DIR = "fonts"

HTML = """
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>###XIMDEX_TITLE###</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            border: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100dvh;
            width: 100dvw;
            overflow-x: hidden;
            background-color: #f0f0f0;

        }
        section {
            width: ###XIMDEX_WIDTH###;
            height: ###XIMDEX_HEIGHT###;
            position: relative;
            background-color: white;
        }
   .hovered {
       outline: 2px dashed #007bff;
       cursor: grab;
   }

   .dragging {
       opacity: 0.7;
       cursor: grabbing;
   }
    </style>
</head>
<body>
    <section>
        ###XIMDEX_CONTENT###
    </section>
</body>
</html>
"""

class AdapterPdf2Html:

    def __init__(self, pdf_path, output_dir):
        self.pdf_document = fitz.open(pdf_path)
        self.pdf_name = Path(pdf_path).stem
        self.main_content_width_threshold = 0.67
        self.fonts = []
        self.zindex = 100000
        self.output_dir = Path(output_dir)

        self.html_page = HTML
        self.html_content = ""
        self.scale = 1
        self.unit_mesuerement = "pt"
        self.json_data = {
            'sections': []
        }
        self.tag_id = 1

    def create_scaffold_output_directory(self):
        self.output_dir.mkdir(parents=True, exist_ok=True)
        (self.output_dir / 'html' ).mkdir(exist_ok=True)
        (self.output_dir / 'html' / IMAGES_DIR).mkdir(exist_ok=True)
        (self.output_dir / 'html' / FONTS_DIR).mkdir(exist_ok=True)

    def decimal_to_hex_color(self, decimal_value):
        hex_value = hex(decimal_value & 0xFFFFFF)[2:]
        hex_value = hex_value.zfill(6)
        return f"#{hex_value.upper()}"

    def process_page(self, page_num, title):
        page = self.pdf_document[page_num]
        page_width = page.rect.width * self.scale
        page_height = page.rect.height * self.scale

        data_section = {
            'page': page_num + 1,
            'width': page_width,
            'height': page_height,
            'images': [],
            'blocks': []
        }

        self.html_page = self.html_page.replace('###XIMDEX_WIDTH###', f"{page_width}{self.unit_mesuerement}")
        self.html_page = self.html_page.replace('###XIMDEX_HEIGHT###', f"{page_height}{self.unit_mesuerement}")
        title_pdf = f"{title} - Página {page_num + 1}"
        self.html_page = self.html_page.replace('###XIMDEX_TITLE###', title_pdf)

        images = self.pdf_document[page_num].get_images(full=True)
        blocks = self.pdf_document[page_num].get_text("dict")['blocks']
        img_count = 0
        for image in images:
            xref = image[0]
            image_info = self.pdf_document.extract_image(xref)

            if image_info:
                try:
                    image_bytes = image_info["image"]
                    pix = fitz.Pixmap(image_bytes)
                    bbox = self.pdf_document[page_num].get_image_bbox(image[7])
                    if bbox[0] < 0 or bbox[1] < 0:
                        pix.set_origin(0, 0)

                    if pix.width > 0 and pix.height > 0:
                        try:
                            pix = fitz.Pixmap(self.pdf_document, xref)
                            pix = fitz.Pixmap(fitz.csRGB, pix)
                            img_data = pix.tobytes("png")
                            image_pix = Image.open(io.BytesIO(img_data))
                            image_pix.save(str(self.output_dir / "html" / "images" / f"page_{page_num}_{img_count}.png"))

                        except:
                            try:
                                pix = fitz.Pixmap(self.pdf_document, xref)
                                pix = fitz.Pixmap(fitz.csRGB, pix)
                                img_data = pix.tobytes("png")
                                image_pix = Image.open(io.BytesIO(img_data))
                                image_pix.save(str(self.output_dir / "html" / "images" / f"page_{page_num}_{img_count}.png"))
                            except Exception as e:
                                print(f"Error to save image {xref}: {e}")
                except Exception as e:
                    print(f"Error to extract image {xref}: {e}")
            else:
                print(f"Error to extract image {xref}: {e}")

            path_img = f"{self.output_dir}/html/images/page_{page_num}_{img_count}.png"
            bbox = self.pdf_document[page_num].get_image_bbox(image[7])
            data_section['images'].append({
                'id': self.tag_id,
                'path': path_img,
                'bbox': self.rect_to_bbox(bbox)
            })
            relative_path = self.output_dir.stem
            relative_path = f"storage/{relative_path}/html/images/page_{page_num}_{img_count}.png"
            data_image = self.generate_image_html(f'image_page_{page_num}_{img_count}', path_img, bbox, relative_path)
            data_section['blocks'].append({
                'type': 'image',
                # 'content': data_image['image'],
                'styles': data_image['styles'],
                'alt': data_image['alt'],
                'bbox': self.rect_to_bbox(bbox),
                'path': f"{self.output_dir.stem}/html/images/page_{page_num}_{img_count}.png",
                'id': self.tag_id
            })
            self.tag_id += 1
            img_count += 1

        for block in blocks:
            tag_id = self.tag_id
            html_text = self.generate_text_html(block, page_num)

        # return {
        #     'content':output_html,
        #     'styles': block_style,
        #     'id': block_id,
        #     'type': block_type,
        #     'blocks': blocks
        # }
            if html_text:
                data_section['blocks'].append({
                    'type': 'text',
                    # 'content': html_text['content'],
                    'bbox': block['bbox'],
                    'id': tag_id,
                    'tag': html_text['type'],
                    'styles': html_text['styles'],
                    'blocks': html_text['blocks']
                })
                self.tag_id += 1

        # html_path = self.output_dir / "html" / f"{self.pdf_name}_page_{page_num + 1}.html"

        # self.html_content = ""
        # for block in data_section['blocks']:
        #     if block['content']:
        #         self.html_content += block['content']

        # with open(html_path, "w", encoding="utf-8") as f:
        #     f.write(self.html_page.replace('###XIMDEX_CONTENT###', self.html_content))

        self.html_content = ""
        self.zindex = 0

        self.json_data['sections'].append(data_section)

    def rect_to_bbox(self, rect):
            return [rect.x0, rect.y0, rect.x1, rect.y1]

    def add_data_to_json(self):
        title_pdf = self.pdf_document.metadata['title'] or self.pdf_name
        self.json_data['title'] = title_pdf
        self.json_data['date'] = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        self.json_data['pages'] = len(self.pdf_document)
        self.json_data['sections'] = []
        self.json_data['metadata'] = self.pdf_document.metadata
        self.json_data['toc'] = self.pdf_document.get_toc()
        self.json_data['fonts'] = []
        self.json_data['unit_mesuerement'] = self.unit_mesuerement

    def process_pdf(self):
        self.add_data_to_json()

        for page_num in range(len(self.pdf_document)):
            self.process_page(page_num, self.json_data['title'])

    def generate_json(self):
        json_path = self.output_dir / "raw.json"
        with open(json_path, "w", encoding="utf-8") as f:
            json.dump(self.json_data, f, indent=4)

    def convert_cff_to_otf(input_path, output_dir=None):
        """
        Convierte un archivo .cff a .otf utilizando fontTools

        Args:
            input_path (str): Ruta al archivo .cff
            output_dir (str, opcional): Directorio de salida. Si no se especifica,
                                        usa el directorio del archivo de entrada

        Returns:
            str: Ruta del archivo convertido
        """
        from fontTools.misc.psCharStrings import T2CharString
        from fontTools.fontBuilder import FontBuilder

        # Directorio de salida
        if output_dir is None:
            output_dir = os.path.dirname(input_path)

        # Nombre base del archivo
        base_name = os.path.splitext(os.path.basename(input_path))[0]

        try:
            # Leer el archivo CFF
            with open(input_path, 'rb') as f:
                cff_data = f.read()

            # Preparar la ruta de salida
            output_path = os.path.join(output_dir, f"{base_name}.otf")

            # Paso 1: Crear un FontBuilder básico
            fb = FontBuilder(1000)  # Unidades por em estándar

            # Paso 2: Añadir el CFF como fuente
            fb.setupCFF(cff_data, isCFF2=False)

            # Paso 3: Añadir algunos metadatos básicos
            fb.setupGlyphOrder()
            fb.setupCharacterMap()

            # Paso 4: Guardar la fuente
            fb.save(output_path)

            return output_path

        except Exception as e:
            print(f"Error convirtiendo CFF a OTF: {e}")
            return None

    def is_justified(self, lines, block_width, threshold=5):
        """
        Determina si las líneas en un bloque de texto están justificadas.
        """
        lines_jusfied = 0
        for line in lines:
            spans = line['spans']
            line_start = spans[0]['bbox'][0]  # Coordenada X inicial de la línea
            line_end = spans[-1]['bbox'][2]  # Coordenada X final de la línea
            line_width = line_end - line_start

            # Si la línea ocupa casi todo el ancho del bloque pero no se centra,
            # podría estar justificada
            if abs(block_width - line_width) < threshold:
                lines_jusfied += 1

        return lines_jusfied > len(lines) / 2

    def generate_text_html(self, text_block, page_num):
        if not 'lines' in text_block:
            return

        content = ''
        raw_txt = ''
        output_html = ''
        id_block = text_block['number']
        initial_pos_x = text_block['bbox'][0]
        initial_pos_y = text_block['bbox'][1]
        width = str((text_block['bbox'][2] - text_block['bbox'][0]) * self.scale)
        height = str((text_block['bbox'][3] -text_block['bbox'][1]) * self.scale)
        left = str(text_block['bbox'][0] * self.scale)
        top = str(text_block['bbox'][1] * self.scale)
        # top = 0
        # left = 0

        font_counter = Counter()
        font_size_counter = Counter()
        font_color_counter = Counter()
        is_justified_block = self.is_justified(text_block['lines'], text_block['bbox'][2] - text_block['bbox'][0])
        font_serif_counter = 0
        span_counter = 0

        for line in text_block['lines']:
            for span in line['spans']:
                font_counter[span['font']] += 1
                font_size_counter[span['size']] += 1
                font_color_counter[span['color']] += 1
                if span['flags'] & 4:
                    font_serif_counter += 1
                span_counter += 1


        font_family_common = "'"
        font_family_common += font_counter.most_common(1)[0][0]
        font_family_common += "'"

        font_size_common = font_size_counter.most_common(1)[0][0] * self.scale
        font_color_common = self.decimal_to_hex_color(font_color_counter.most_common(1)[0][0])

        style = f"position: relative;  z-index: {self.zindex}; color: {font_color_common}; font-family: {font_family_common}; font-size: {font_size_common}{self.unit_mesuerement}; "
        blocks = []
        block_style = ''
        block_type = 'p'
        block_id = self.tag_id
        counter_p  = 0
        last_span_styles = ''
        for line in text_block['lines']:
            for idx_span, span in enumerate(line['spans']):
                span_styles = ''
                span_txt = span['text']
                span_id = self.tag_id
                span_type = 'text'
                if top is False:
                    top = span['bbox'][1] * self.scale
                if left is False:
                    left = span['bbox'][0] * self.scale
                flags = span["flags"]

                superscripted = bool(flags & 1)     # Bit 0
                italic = bool(flags & 2)            # Bit 1
                bold = bool(flags & 16)             # Bit 4
                serifed = bool(flags & 4)
                monospaced = bool(flags & 8)

                text = span['text']
                text = text.strip()

                if len(text) == 0:
                    continue

                if len(line['spans']) == idx_span + 1 and text[-1] == '-':
                    text = text[:-1]

                raw_txt += text
                font_size = span['size'] * self.scale
                font_color = self.decimal_to_hex_color(span['color'])
                font_family = "'" + span['font'] + "'"

                relative_pox_x = span['bbox'][0] - initial_pos_x
                relative_pox_y = span['bbox'][1] - initial_pos_y
                width = (span['bbox'][2] - span['bbox'][0]) * self.scale
                height = (span['bbox'][3] - span['bbox'][1]) * self.scale
                relative_width = (span['bbox'][2] - span['bbox'][0]) * self.scale
                relative_height = (span['bbox'][3] - span['bbox'][1]) * self.scale
                span_style = f'position: relative; font-family: {font_family}; font-size: {font_size}{self.unit_mesuerement}; color: {font_color};'

                _font_size = (font_size / self.font_size_common)
                if _font_size != 1:
                    _font_size = round(_font_size, 2)
                    span_styles += f'font-size: {_font_size}rem;'

                if superscripted:
                    text = f'<sup id="{self.tag_id}">{text}</sup>'
                    span_styles += ' vertical-align: super;'
                    # self.tag_id += 1
                if bold:
                    text = f'<b id="{self.tag_id}">{text}</b>'
                    span_styles += ' font-weight: bold;'
                    # self.tag_id += 1
                if italic:
                    text = f'<i id="{self.tag_id}">{text}</i>'
                    span_styles += ' font-style: italic;'
                    # self.tag_id += 1

                span_style = ''
                if span['font'] != font_family_common:
                    span_style += f'font-family: {font_family};'
                if span['size'] != font_size_common:
                    span_style += f'font-size: {font_size}{self.unit_mesuerement};'
                if span['color'] != font_color_common:
                    span_style += f'color: {font_color};'

                if span['color'] != self.font_color_common:
                    span_styles += f' color: {font_color};'

                if span_style:
                    text = f'<span id="{self.tag_id}" style="{span_style}">{text}</span>'
                    # self.tag_id += 1

                if superscripted or bold or italic or span_style:
                    content += ' ' + text + ' '
                else:
                    content += text

                if span_styles != '':
                    span_type = 'span'

                if len(blocks) > 0 and last_span_styles == span_styles:
                    if blocks[-1]['content'][-1] == '-':
                        blocks[-1]['content'] = blocks[-1]['content'][:-1]
                        blocks[-1]['content'] += span_txt
                    elif blocks[-1]['content'][-1] == ' ':
                        blocks[-1]['content'] += span_txt
                    else:
                        blocks[-1]['content'] += " " + span_txt
                else:
                    blocks.append({
                        'type': span_type,
                        'content': span_txt,
                        'styles': span_styles,
                        'id': span_id
                    })
                    last_span_styles = span_styles
                    self.tag_id += 1

            if (len(blocks) > 0 and blocks[-1]['content'][-1] == '-'):
                blocks[-1]['content'] = blocks[-1]['content'][:-1]
                content = content[:-1]

            if len(content) > 0 and content[-1] == '-':
                content = content[:-1]

            # if len(raw_txt) > 0 and raw_txt[-1] in [".", ":"]:
            #     height = height - line['bbox'][3]
            #     _style = f''
            #     top = False
            #     left = False
            #     html_content = f'<p id="{self.tag_id}" style=\"{style}{_style}\">{content}</p>'
            #     self.tag_id += 1
            #     output_html += html_content
            #     self.zindex += 1
            #     counter_p += 1
            #     content = ''
            #     return {
            #         'content':output_html,
            #         'styles': block_style,
            #         'id': block_id,
            #         'type': block_type,
            #         'blocks': blocks
            #     }


        if top is False and left is False:
            return

        _style = f''
        html_content = f'<p id="{self.tag_id}" style=\"{style}{_style}\">{content}</p>'
        self.tag_id += 1
        output_html += html_content
        self.zindex += 1
        return {
            'content':output_html,
            'styles': block_style,
            'id': block_id,
            'type': block_type,
            'blocks': blocks
        }

    def generate_image_html(self, image_name, path, bbox, relative_path):
        posx = bbox[0] * self.scale
        posy = bbox[1] * self.scale
        width = (bbox[2] - posx) * self.scale
        height = (bbox[3] - posy) * self.scale
        style = f'position: relative;  z-index: {self.zindex};'
        image =  f'<img id="{self.tag_id}" src="{relative_path}" style="{style}" alt="{image_name}">'
        self.zindex += 1
        return {
            'image': image,
            'styles': style,
            'alt': image_name,
            'id': self.tag_id,
            'z-index': self.zindex -1
        }


    def pdf_to_markdown(self):
        markdown_content = ""

        for page_num, page in enumerate(self.pdf_document, start=1):
            text = page.get_text("text")
            markdown_content += f"# Page {page_num} of {self.pdf_document.page_count}\n\n{text}\n\n"

        # Guardar el contenido extraído en un archivo Markdown
        with open(self.output_dir / 'raw.md', "w", encoding="utf-8") as md_file:
            md_file.write(markdown_content)

    def is_overlapping(self, bbox1, bbox2):
        x1, y1, x2, y2 = bbox1
        x3, y3, x4, y4 = bbox2
        return not (x2 < x3 or x4 < x1 or y2 < y3 or y4 < y1)

    def detect_columns(self, blocks, tolerance=10):
        lefts = sorted(blocks['bbox'].apply(lambda bbox: bbox[0]).unique())
        clusters = []
        current_cluster = [lefts[0]]

        for left in lefts[1:]:
            if abs(left - current_cluster[-1]) <= tolerance:
                current_cluster.append(left)
            else:
                clusters.append(current_cluster)
                current_cluster = [left]
        clusters.append(current_cluster)

        column_map = {val: idx for idx, cluster in enumerate(clusters) for val in cluster}
        blocks['column'] = blocks['bbox'].apply(lambda bbox: column_map[bbox[0]])
        return blocks

    def getCommons(self):
        font_sizes = Counter()
        font_colors = Counter()
        for idx_page, _ in enumerate(self.pdf_document):
            for block in self.pdf_document[idx_page].get_text("dict")['blocks']:
                if 'lines' not in block:
                    continue
                for line in block['lines']:
                    for span in line['spans']:
                        font_sizes[span['size']] += 1
                        font_colors[span['color']] += 1
        self.font_size_common = font_sizes.most_common(1)[0][0]
        self.font_color_common = font_colors.most_common(1)[0][0]

    def normalize_bbox(self, bbox):
        if len(bbox) == 4 and isinstance(bbox, list):
            return bbox
        elif isinstance(bbox, list) and len(bbox) == 2 and all(isinstance(coord, tuple) for coord in bbox):
            return [bbox[0][0], bbox[0][1], bbox[1][0], bbox[1][1]]
        else:
            return [bbox[0], bbox[1], bbox[2], bbox[3]]

    def sort_blocks(self, blocks):

        for block in blocks:
            block['bbox'] = self.normalize_bbox(block['bbox'])

        df = pd.DataFrame(blocks)

        if not df.empty:
            unique_lefts = df['bbox'].apply(lambda bbox: bbox[0]).nunique()
            if unique_lefts > 1:
                df = self.detect_columns(df)
                df['sort_key'] = df.apply(lambda row: (row['column'], row['bbox'][1], row['bbox'][0]), axis=1)
            else:
                df['sort_key'] = df['bbox'].apply(lambda bbox: (bbox[1], bbox[0]))

        sorted_blocks = df.sort_values(by='sort_key').to_dict(orient='records')

        final_order = []
        for block in sorted_blocks:
            if block['type'] == 'image':
                final_order.append(block)
                overlapping_texts = [b for b in sorted_blocks if b['type'] == 'text' and self.is_overlapping(b['bbox'], block['bbox'])]
                final_order.extend(overlapping_texts)
                sorted_blocks = [b for b in sorted_blocks if b not in overlapping_texts]
            elif block not in final_order:
                final_order.append(block)

        return final_order

    def close(self):
        self.pdf_document.close()

def process_pdf(pdf_path, output_dir=None):
    analyzer = AdapterPdf2Html(pdf_path, output_dir)
    analyzer.create_scaffold_output_directory()
    analyzer.getCommons()
    analyzer.process_pdf()
    analyzer.pdf_to_markdown()
    analyzer.generate_json()
    analyzer.close()

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description='Extract text and images from a PDF file')
    parser.add_argument('pdf', help='Path to the PDF file')
    parser.add_argument('output', help='Output directory', default=None)
    args = parser.parse_args()
    pdf_path = args.pdf
    outputdir = args.output
    try:
        process_pdf(pdf_path, outputdir)
    except Exception as e:
        print(f"Error: {e}")
