<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ParseXlsx;
use Illuminate\Support\Facades\App;
use PDF;

class CreateFormController extends Controller
{
    public function index()
    {
        $parseXlsx = App::make('App\Classes\ParseXlsx');
        $rows = $parseXlsx->readFileContent(ParseXlsx::SOURCE_FILE);
        return view('index', ['rows' => $rows, 'length' => count($rows)]);
    }

    public function createPdf(Request $request)
    {
        if ($request->isMethod('post') || $request->isMethod('get')) {
            $file = public_path() . '\files\selected_items.txt';
            foreach ($request->all() as $req) {
                file_put_contents($file, $req);
            }
            $data = file_get_contents($file);
            $pdfOutput = [
                'selected' => explode(",", $data),
            ];
            unset($pdfOutput['selected'][count($pdfOutput['selected']) - 1]);
            try {
                if (!empty($data)) {
                    $pdf = PDF::loadView('pdf', ['selectedData' => $pdfOutput]);
                    return $pdf->download('dataForm.pdf');
                } else {
                    echo "Pdf file is empty.";
                }

            } catch (Exception $e) {
               echo $e->getMessage();
            }
        }
    }
}
