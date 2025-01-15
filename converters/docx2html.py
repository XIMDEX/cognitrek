import argparse
import mammoth
import os
from pathlib import Path

def convert_docx_to_html(input_path, output_dir):
    """
    Convierte un archivo DOCX a HTML y guarda las imágenes en un subdirectorio.
    
    Args:
        input_path (str): Ruta al archivo DOCX
        output_dir (str): Directorio donde se guardará el HTML y las imágenes
    """
    # Crear directorio de salida si no existe
    output_path = Path(output_dir)
    output_path.mkdir(parents=True, exist_ok=True)
    
    # Crear subdirectorio para imágenes
    images_dir = output_path / "images"
    images_dir.mkdir(exist_ok=True)
    
    # Función para manejar las imágenes
    def handle_image(image):
        with image.open() as image_bytes:
            # Generar nombre único para la imagen
            image_filename = f"image_{hash(image_bytes.read())}.png"
            image_path = images_dir / image_filename
            
            # Guardar imagen
            with open(image_path, 'wb') as f:
                image_bytes.seek(0)
                f.write(image_bytes.read())
            
            # Retornar ruta relativa para el HTML
            return {"src": f"images/{image_filename}"}
    
    # Convertir DOCX a HTML
    with open(input_path, "rb") as docx_file:
        result = mammoth.convert_to_html(docx_file, convert_image=handle_image)
        html = result.value
        messages = result.messages  # Mensajes de advertencia
    
    # Crear HTML completo con estilos básicos
    full_html = f"""<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {{ font-family: Arial, sans-serif; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; }}
        table {{ border-collapse: collapse; width: 100%; margin: 15px 0; }}
        td, th {{ border: 1px solid #ddd; padding: 8px; }}
        img {{ max-width: 100%; height: auto; }}
    </style>
</head>
<body>
{html}
</body>
</html>"""
    
    # Guardar HTML
    output_file = output_path / f"{Path(input_path).stem}.html"
    with open(output_file, 'w', encoding='utf-8') as f:
        f.write(full_html)
    
    # Imprimir mensajes de advertencia si los hay
    if messages:
        print("\nAdvertencias durante la conversión:")
        for message in messages:
            print(f"- {message}")
    
    return output_file

if __name__ == "__main__":
    import sys
    
    if len(sys.argv) != 3:
        print("Uso: python script.py <archivo_docx> <directorio_salida>")
        sys.exit(1)
    
    input_file = sys.argv[1]
    output_dir = sys.argv[2]


    parser = argparse.ArgumentParser(description='Extract text and images from a PDF file')
    parser.add_argument('output', help='Output directory', default=None)
    parser.add_argument('pdf', help='Path to the PDF file')
    args = parser.parse_args()
    doc_path = args.pdf_path
    outputdir = args.outputdir
    
    try:
        convert_docx_to_html(doc_path, outputdir)
        print(f"\nConversión exitosa. Archivo guardado en: {outputdir}")
    except Exception as e:
        print(f"Error durante la conversión: {e}")