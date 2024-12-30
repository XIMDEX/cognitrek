<?php

return [
    'name' => 'LlmModule',
    'version' => '1.0.0',

    'services' => [
        'llm_service' => \Modules\LlmModule\Services\LLMService::class,
    ],
    'prompts' => [
        'dyslexia' => [
            'low' => <<<PROMPT
Prompt:
Adapt the following HTML content to make it accessible for a person with mild dyslexia. Apply the following adjustments:
    1.	Content Simplification:
    •	Break long sentences into shorter, simpler sentences.
    •	Highlight key words or important terms in bold within the content.
    2.	Structure Enhancements:
    •	Organize lists with bullet points or numbers where applicable.
    •	Ensure each section starts with a clear and concise main idea.
    3.	Output Requirements:
    •	The output must retain the original HTML structure, returning the modified content as an HTML string.
    •	Additionally, provide a JSON object indicating the positions of all modified words or phrases. Each entry in the JSON should include:
    •	The id of the modified element.
    •	The original text.
    •	The modified text or the applied style (e.g., bolded words).

Input HTML:
[Insert the HTML string here]

Output Format:
    1.	Modified HTML String: The updated content as an HTML string.
    2.	JSON Object: A list of modifications with the following structure:

[
    {
    "id": "unique_element_id",
    "original_text": "original text here",
    "start_position_modification": "start position of modification in tag element",
    "end_position_modification": "end position of modification in tag element",
    "modified_text": "modified text here",
    "modification": "description of the change (e.g., bolded, simplified)"
    },
    ...
]

Ensure the output HTML structure is intact, and each modification is precisely mapped in the JSON.
PROMPT,
            'mid' => <<<PROMPT
Prompt:

Adapt the following HTML content to make it accessible for a person with moderate dyslexia. Apply the following adjustments:
	1.	Content Simplification:
		•	Simplify sentences further, using concrete language and breaking down complex ideas into smaller, manageable parts.
		•	Replace technical or abstract terms with simpler language or include a brief explanation next to them.
		•	Highlight key terms or phrases in bold.
	2.	Structural Enhancements:
		•	Reorganize content into shorter paragraphs with clear headings for each section.
		•	Use bullet points or numbered lists for information that can be itemized.
		•	Begin each section with a clear and concise statement summarizing its content.
	3.	Visualization Improvements:
		•	Explicitly show relationships between ideas using words like “because,” “due to,” or “as a result.”
		•	Incorporate short explanatory phrases for diagrams, images, or data referenced in the text.
	4.	Output Requirements:
		•	The output must retain the original HTML structure and return the modified content as an HTML string.
		•	Additionally, provide a JSON object listing all modified elements. Each entry in the JSON should include:
		•	The id of the modified element.
		•	The original text.
		•	The modified text or the applied style (e.g., bolded, simplified).
		•	A description of the change.

Input HTML:
[Insert the HTML string here]

Output Format:
	1.	Modified HTML String: The updated content as an HTML string.
	2.	JSON Object: A list of modifications with the following structure:

[
  {
    "id": "unique_element_id",
    "original_text": "original text here",
    "modified_text": "modified text here",
    "modification": "description of the change (e.g., bolded, simplified, restructured)"
  },
  ...
]

Ensure the output HTML structure is preserved, and all modifications are accurately documented in the JSON.
PROMPT,
            'hight' => <<<PROMPT
Prompt:

Adapt the following HTML content to make it accessible for a person with severe dyslexia. Apply the following adjustments:
	1.	Content Simplification:
	•	Reduce text complexity to the minimum by using short, simple sentences.
	•	Replace abstract or technical terms with tangible, everyday language, or provide a direct, brief explanation.
	•	Highlight key terms or phrases in bold.
	2.	Structural Enhancements:
	•	Organize the content into very short paragraphs with one idea per paragraph.
	•	Use clear headings for every section and subsection.
	•	Present complex information using bullet points, numbered lists, or tables where applicable.
	•	Ensure each section begins with an easily understandable summary.
	3.	Visualization and Accessibility:
	•	Prioritize visuals, such as diagrams or images, to replace or complement text when possible.
	•	Add brief, explanatory text for visuals to ensure clarity.
	•	Explicitly connect ideas using simple language, with phrases like “this means,” “because,” or “as a result.”
	4.	Output Requirements:
	•	The output must retain the original HTML structure and return the modified content as an HTML string.
	•	Additionally, provide a JSON object listing all modifications made. Each entry in the JSON should include:
	•	The id of the modified element.
	•	The original text.
	•	The modified text or description of the applied change (e.g., simplified, bolded, restructured).
	•	A description of why the change was made (e.g., to improve clarity, reduce complexity).

Input HTML:
[Insert the HTML string here]

Output Format:
	1.	Modified HTML String: The updated content as an HTML string.
	2.	JSON Object: A detailed list of modifications with the following structure:

[
  {
    "id": "unique_element_id",
    "original_text": "original text here",
    "modified_text": "modified text here",
    "modification": "description of the change (e.g., bolded, simplified, replaced by visual)",
    "reason": "explanation for the change (e.g., to improve clarity or replace abstract term)"
  },
  ...
]

Ensure the output HTML structure is preserved, the text is significantly simplified, and the JSON thoroughly documents all changes made.
PROMPT
        ],
        'tda' => [
            'low' => "",
            'mid' => "",
            'hight' => ""
        ],
    ]
];