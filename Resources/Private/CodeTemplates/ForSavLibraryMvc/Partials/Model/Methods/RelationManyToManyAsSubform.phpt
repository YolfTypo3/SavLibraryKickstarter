{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}
    /**
     * Adds a {field.fieldname->sav:lowerCamel()}
     * 
     * @param {field.conf_rel_table->sav:Mvc.BuildModelName(extension:extension)} ${field.fieldname->sav:lowerCamel()}
     * @return void
     */
    public function add{field.fieldname->sav:upperCamel()}({field.conf_rel_table->sav:Mvc.BuildModelName(extension:extension)} ${field.fieldname->sav:lowerCamel()})
    {
        $this->{field.fieldname->sav:lowerCamel()}->attach(${field.fieldname->sav:lowerCamel()});
    }
!
    /**
     * Removes a {field.fieldname->sav:lowerCamel()}
     * 
     * @param {field.conf_rel_table->sav:Mvc.BuildModelName(extension:extension)} ${field.fieldname->sav:lowerCamel()}
     * @return void
     */
    public function remove{field.fieldname->sav:upperCamel()}({field.conf_rel_table->sav:Mvc.BuildModelName(extension:extension)} ${field.fieldname->sav:lowerCamel()})
    {
        $this->{field.fieldname->sav:lowerCamel()}->detach(${field.fieldname->sav:lowerCamel()});
    }
