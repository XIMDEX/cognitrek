<?php

namespace Modules\VisorModule\Services;

class VisorService
{
    public function performAction($params = null)
    {
    }

    public function visor($resource, $modified)
    {
        try {
            
            $data = [
                'resource' => $resource,
                'dyslexic_level' => 'low',
                'tda_level' => false,
                'lang' => $resource['lang'],
                'modified' => [
                    223 => "<p id=\"216-1\" data-orig=\"216\" style=\"font-family: 'SRASans1.0-Book';color: #231F20;\">Esto es una prueba de texto añadido que debe verse <b>correcto</b></p>",
                    149 => "<p id=\"222-1\" style=\"position: relative;  z-index: 16; color: #231F20; font-family: 'SRASans1.0-Book'; font-size: 9.75pt; \"> <span id=\"215\" style=\"font-family: 'SRASans1.0-Bold';color: #B82837;\"><b id=\"214\">1.</b></span>  <span id=\"216\" style=\"font-family: 'SRASans1.0-Book';color: #231F20;\">Inventa dos o tres contextos no verbales diferentes que</span>  <span id=\"217\" style=\"font-family: 'SRASans1.0-Book';color: #231F20;\">hagan cambiar el significado de la oración:</span>  <span id=\"219\" style=\"font-family: 'SRASans1.0-Italic';color: #231F20;\"><i id=\"218\">Aún no he visto</i></span>  <span id=\"221\" style=\"font-family: 'SRASans1.0-Italic';color: #231F20;\"><i id=\"220\">la carta.</i></span> </p>"
                ],
                'modified_ids' => [149],
                'deleted_ids' => [211],
                'added_ids' => [223]
            ];

            return response()->view('visor::visor', $data);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Resource view failed', 'error' => $e->getMessage()], 500);
        }
    }


    public function preview($resource, $modified)
    {
        try {
            
            $data = [
                'resource' => $resource,
                'dyslexic_level' => 'low',
                'tda_level' => false,
                'lang' => $resource['lang'],
                'modified' => [
                    223 => "<p id=\"216-1\" data-orig=\"216\" style=\"font-family: 'SRASans1.0-Book';color: #231F20;\">Esto es una prueba de texto añadido que debe verse <b>correcto</b></p>",
                    149 => "<p id=\"222-1\" style=\"position: relative;  z-index: 16; color: #231F20; font-family: 'SRASans1.0-Book'; font-size: 9.75pt; \"> <span id=\"215\" style=\"font-family: 'SRASans1.0-Bold';color: #B82837;\"><b id=\"214\">1.</b></span>  <span id=\"216\" style=\"font-family: 'SRASans1.0-Book';color: #231F20;\">Inventa dos o tres contextos no verbales diferentes que</span>  <span id=\"217\" style=\"font-family: 'SRASans1.0-Book';color: #231F20;\">hagan cambiar el significado de la oración:</span>  <span id=\"219\" style=\"font-family: 'SRASans1.0-Italic';color: #231F20;\"><i id=\"218\">Aún no he visto</i></span>  <span id=\"221\" style=\"font-family: 'SRASans1.0-Italic';color: #231F20;\"><i id=\"220\">la carta.</i></span> </p>"
                ],
                'modified_ids' => [149],
                'deleted_ids' => [211],
                'added_ids' => [223]
            ];

            return response()->view('visor::preview', $data);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Resource view failed', 'error' => $e->getMessage()], 500);
        }
    }
}
