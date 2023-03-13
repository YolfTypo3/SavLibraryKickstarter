    /**
     * Adds a {field.fieldname->sav:format.lowerCamel()}
     * 
     * @param {field.conf_rel_table->sav:builder.mvc.modelName(extension:extension)} ${field.fieldname->sav:format.lowerCamel()}
     * @return void
     */
    public function add{field.fieldname->sav:format.upperCamel()}({field.conf_rel_table->sav:builder.mvc.modelName(extension:extension)} ${field.fieldname->sav:format.lowerCamel()})
    {
        $this->{field.fieldname->sav:format.lowerCamel()}->attach(${field.fieldname->sav:format.lowerCamel()});
    }
!
    /**
     * Removes a {field.fieldname->sav:format.lowerCamel()}
     * 
     * @param {field.conf_rel_table->sav:builder.mvc.modelName(extension:extension)} ${field.fieldname->sav:format.lowerCamel()}
     * @return void
     */
    public function remove{field.fieldname->sav:format.upperCamel()}({field.conf_rel_table->sav:builder.mvc.modelName(extension:extension)} ${field.fieldname->sav:format.lowerCamel()})
    {
        $this->{field.fieldname->sav:format.lowerCamel()}->detach(${field.fieldname->sav:format.lowerCamel()});
    }
