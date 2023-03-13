<f:format.raw> 
!    
    /**
     * Getter for property <{lowerCamelFieldName}>.
     *
<f:if condition="{field.conf_relations_mm}">
<f:then>
     * @return {type}
</f:then>
<f:else>
     * @return string
</f:else>
</f:if>     */
    public function get{upperCamelFieldName}(): {f:if(condition:field.conf_relations_mm, then:'?\TYPO3\CMS\Extbase\Persistence\ObjectStorage', else:'?string')}
    {
        return $this->{lowerCamelFieldName};
    }
!
    /**
     * Setter for property <{lowerCamelFieldName}>.
     *
<f:if condition="{field.conf_relations_mm}">
<f:then>
     * @param {type} ${lowerCamelFieldName}
</f:then>
<f:else>
     * @param string
</f:else>
</f:if>
     * @return void
     */
    public function set{upperCamelFieldName}({f:if(condition:field.conf_relations_mm, then:'\TYPO3\CMS\Extbase\Persistence\ObjectStorage', else:'string')} ${lowerCamelFieldName})
    {
        $this->{lowerCamelFieldName} = ${lowerCamelFieldName};
    }
<f:if condition="{field.conf_relations_mm}">
<f:variable name="typeForAddRemove">{type->sav:format.regexp(pattern:'/^.*?\<(.*?)\>$/', replacement:'$1')}</f:variable>
!
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
     * @param {typeForAddRemove} ${field.fieldname->sav:format.lowerCamel()}
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
</f:if>
</f:format.raw> 