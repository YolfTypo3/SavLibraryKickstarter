<f:format.raw>
!    
    /**
     * Getter for property <{lowerCamelFieldName}>.
     *
     * @return {type}
     */
    public function get{upperCamelFieldName}(): ?\TYPO3\CMS\Extbase\Persistence\ObjectStorage
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
    public function set{upperCamelFieldName}(\TYPO3\CMS\Extbase\Persistence\ObjectStorage ${lowerCamelFieldName})
    {
        $this->{lowerCamelFieldName} = ${lowerCamelFieldName};
        $this->{lowerCamelFieldName}->_memorizeCleanState();
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
!
    /**
     * Unsets a <{lowerCamelFieldName}>.
     * 
     * @return void
     */
    public function unset{upperCamelFieldName}()
    {
        unset($this->{lowerCamelFieldName});
    }   
</f:format.raw>   