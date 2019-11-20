<?php

namespace koperdog\yii2settings\fields\base;

/*
 * Copyright 2019 Koperdog <koperdog@github.com>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * base class for render input field
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 */
abstract class BaseInput implements Input{
    /**
     * standart field type
     */
    const FIELD_TYPE = "text";
    
    /**
     * General data for the field
     * 
     * @var array
     */
    private $data;
    
    /**
     * All attributes of the field
     * @var array
     */
    private $attributes = [];
    
    /**
     * html input (result of render)
     * 
     * @var string
     */
    private $html = "";
    
    private $template = "<input {attributes}/>";
    
    public function __construct(array $data = [])
    {
        $this->data = $data;
        $this->load();
        
        $this->setAttribute("type", static::FIELD_TYPE);
    }
    
    public function render(): string
    {
        $attributes = implode(" ", $this->renderAttributes());
        $this->template = str_replace("{attributes}", $attributes, $this->template);
        
        return $this->template;
    }
    
    public function setAttribute(string $name, string $value): void
    {
        $this->attributes[$name] = $value;
    }
    
    public function setAttributes(array $attributes): void
    {
        foreach($attributes as $name => $value){
            $this->setAttribute($name, $value);
        }
    }
    
    public function removeAttribute(string $name): void
    {
        unset($this->attributes[$name]);
    }
    
    private function renderAttributes(): array
    {
        $render = [];
        
        foreach($this->attributes as $name => $value){
            $render[] = $name.'="'.$value.'"';
        }
        
        return $render;
    }
    
    private function load(): void
    {
        if(isset($this->data['attributes'])){
            $this->attributes = $this->data['attributes'];
        }
        
        if(isset($this->data['template'])){
            $this->template = $this->data['template'];
        }
    }
}
