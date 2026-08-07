{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}
<f:format.raw>
!    
    /**
     * Getter for property <{lowerCamelFieldName}>.
     *
     * @return {type}
     */
    public function get{upperCamelFieldName}(): ?ObjectStorage
    {
        return $this->{lowerCamelFieldName};
    }
!
    /**
     * Setter for property <{lowerCamelFieldName}>.
     *
     * @param  {type} ${lowerCamelFieldName}
     * @return void
     */
    public function set{upperCamelFieldName}(ObjectStorage ${lowerCamelFieldName}): void
    {
        $this->{lowerCamelFieldName} = ${lowerCamelFieldName};
    }
!
<f:variable name="typeForAddRemove">{type->sav:format.regexp(pattern:'/^.*?\<(.*?)\>$/', replacement:'$1')}</f:variable>

    /**
     * Adds a <{lowerCamelFieldName}>.
     * 
     * @param {typeForAddRemove} ${lowerCamelFieldName}
     * @return void
     */
    public function add{upperCamelFieldName}({typeForAddRemove} ${lowerCamelFieldName})
    {
        $this->{lowerCamelFieldName}->attach(${lowerCamelFieldName});
    }
!
    /**
     * Removes a <{lowerCamelFieldName}>.
     * 
     * @param {typeForAddRemove} ${lowerCamelFieldName}
     * @return void
     */
    public function remove{upperCamelFieldName}({typeForAddRemove} ${lowerCamelFieldName})
    {
        $this->{lowerCamelFieldName}->detach(${lowerCamelFieldName});
    }
 
</f:format.raw>   