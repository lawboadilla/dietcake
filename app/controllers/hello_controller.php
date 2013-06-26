<?php

class HelloController extends AppController
{
   	public function index()
    {
        // $chara = Hello::getAll();
        $this->set(get_defined_vars());
    }
}
