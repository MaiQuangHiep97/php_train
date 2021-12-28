<?php

interface RepositoryInterface
{
    public function getAll();

    
    public function find($id);

    
    public function insert($attributes = []);

    
    public function update($id, $attributes = []);

    
    public function delete($id);
}
