<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public static function get($filter = NULL) {
        if ($filter == NULL) {
            return new Faq;
        }
        return Faq::where($filter);
    }
    public function store(Request $request) {
        $saveData = Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('admin.faq')->with(['message' => "Faq berhasil ditambahkan"]);
    }
    public function update(Request $request) {
        $id = $request->id;
        $updateData = Faq::where('id', $id)->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('admin.faq')->with(['message' => "Faq berhasil diubah"]);
    }
    public function delete($id) {
        $updateData = Faq::where('id', $id)->delete();
        return redirect()->route('admin.faq')->with(['message' => "Faq berhasil dihapus"]);
    }
}
