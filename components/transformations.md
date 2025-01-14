# Documentation of Python Scripts

**This component is located in the `converters` folder.**

This document provides detailed information about two Python scripts, docx2html.py and pdf2html.py, designed to convert .docx and .pdf files into structured HTML formats. These scripts aim to facilitate document processing by extracting text, images, and metadata while preserving the original structure as much as possible.

## docx2html.py

### Overview

This script processes Microsoft Word documents (.docx) and converts their content into an HTML format. It extracts text, tables, and images from the document, creating a fully formatted HTML file that mimics the original structure.

### Features
* Extracts text, tables, and images from .docx files.
* Generates a well-structured HTML file with embedded styles for ease of use.
* Handles warnings for unsupported elements (e.g., certain shapes or formatting).

### Key Functions
1.	convert_docx_to_html(input_path, output_path)
    * Purpose: Converts a .docx file into an HTML document.
    * Process:
        * Reads the input .docx file using a library like python-docx.
        * Extracts the document’s structure, including paragraphs, images, and tables.
        * Formats the content into an HTML file with inline CSS for styling.
    * Parameters:
        * input_path: Path to the .docx file to be converted.
        * output_path: Directory where the HTML file will be saved.
    * Returns: The generated HTML file.
2.	Error and Warning Handling
    * Logs warnings if unsupported elements (e.g., certain shapes) are encountered during the conversion.

### Input and Output
* Input: 
    * A .docx file.
    * A directory for the output HTML file.
* Output: An HTML file representing the content of the .docx file.

### Usage

Run the script from the command line as follows:

`python docx2html.py <docx_file> <output_directory>`

## pdf2html.py

### Overview

This script is a more comprehensive tool designed to process PDF files. It extracts text, images, and metadata from each page of a PDF and creates:
* An interactive HTML file.
* A JSON file containing the document’s structure, metadata, and layout.
* A Markdown file with the extracted plain text.

### Features
* Extracts text and images from each page of the PDF.
* Generates a responsive HTML document styled with inline CSS.
* Outputs a JSON file with detailed metadata and structure.
* Supports conversion to Markdown for easier text manipulation.

### Key Classes and Functions
1.	AdapterPdf2Html
    * A class designed to encapsulate the logic for processing PDF files.
    * Attributes:
        * pdf_document: The loaded PDF file object.
        * html_page: Template for the HTML output.
        * json_data: Stores extracted metadata and content for JSON output.
        * output_dir: Directory where the output files will be saved.
    * Methods:
        * process_page(page_num, title): Processes a single page of the PDF to extract text and images.
        * generate_text_html(text_block, page_num): Converts text blocks into styled HTML elements.
        * generate_image_html(image_name, path, bbox): Embeds images into the HTML output.
        * pdf_to_markdown(): Converts the extracted text into Markdown format.
        * generate_json(): Creates a structured JSON file containing metadata and content.
2.	Standalone Functions
    * process_pdf(pdf_path, output_dir): Entry point for processing a PDF. It initializes the AdapterPdf2Html class, processes the PDF, and generates all outputs.

### Input and Output
* Input: 
    * A PDF file.
    * A directory for storing output files.
* Output:
    * HTML file: A structured and interactive representation of the PDF.
    * JSON file: Contains metadata (e.g., author, title, creation date) and content structure (e.g., bounding boxes, fonts).
    * Markdown file: Simplified plain text extracted from the PDF.

### Usage

Run the script from the command line: `python pdf2html.py <pdf_file> <output_directory>`

## Dependencies

Both scripts require Python and specific third-party libraries to function properly. Below is the list of required libraries and their purposes.

### Common Dependencies
* Python >= 3.6
* Libraries:
    * argparse: For parsing command-line arguments.
    * fitz (PyMuPDF): For processing PDF files.
    * Pillow: For handling image extraction and manipulation.
    * pathlib: For file and directory management.
    * json: For generating structured output in JSON format.
    * datetime: For timestamping outputs.
    * collections: For counting occurrences of text attributes.

## Installation

Install the required libraries using virtual enviroment and `requirements.txt`

```SHELL
$ python3 -m venv venv
$ source venv/bin/activate
(venv)$ pip install -r requeriments.txt
```

## Output Structure

### docx2html.py Output
* HTML file:
    * Inline CSS for styling.
    * Includes all text, images, and tables extracted from the .docx.

### pdf2html.py Outputs
1.	HTML:
    * A standalone file with embedded images and text elements styled for display.
    * Each page of the PDF is represented as a section in the HTML.
2.	JSON:
    * Contains metadata such as title, author, and table of contents.
    * Provides detailed information about text and images, including their positions and bounding boxes.
3.	Markdown:
    * A plain-text representation of the PDF’s content, useful for further processing.

## Project Use Case

These scripts are ideal for projects requiring:
1.	Conversion of .docx or .pdf documents into web-friendly formats.
2.	Extraction of structured metadata and content for indexing or search purposes.
3.	Simplification of text-based document processing workflows.

They can be integrated into larger pipelines for document digitization, search engine indexing, or data analytics in projects.
