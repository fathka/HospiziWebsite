<?php

namespace App\Controllers;

use App\Models\TemplateDietModel;

class TemplateDiet extends BaseController
{
    protected $templateDietModel;

    public function __construct()
    {
        $this->templateDietModel = new TemplateDietModel();
    }

    public function index()
    {
        $templates = $this->templateDietModel->findAll();
        return view('ahli_gizi/template-diet', compact('templates'));
    }

    public function create()
    {
        return view('ahli_gizi/template-diet-create');
    }

    public function store()
    {
        $data = $this->request->getPost();
        $this->templateDietModel->insert($data);
        return redirect()->to('/ahli-gizi/template-diet')->with('success', 'Template berhasil disimpan');
    }

    public function edit($id)
    {
        $template = $this->templateDietModel->find($id);
        return view('ahli_gizi/template-diet-edit', compact('template'));
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $this->templateDietModel->update($id, $data);
        return redirect()->to('/ahli-gizi/template-diet')->with('success', 'Template berhasil diupdate');
    }
}
