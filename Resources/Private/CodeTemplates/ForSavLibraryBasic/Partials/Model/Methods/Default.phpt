<f:format.raw>   
    /**
     * Getter for property <{lowerCamelFieldName}>.
     *
     * @return {type}
     */
    public function get{upperCamelFieldName}()
    {
	    <f:if condition="{field.extensionScannerIgnoreLine}">
	    // @extensionScannerIgnoreLine
	    </f:if>    
        return $this->{lowerCamelFieldName};
    }
!
    /**
     * Setter for property <{lowerCamelFieldName}>.
     *
     * @param {type} ${lowerCamelFieldName}
     * @return void
     */
    public function set{upperCamelFieldName}(${lowerCamelFieldName})
    {
	    <f:if condition="{field.extensionScannerIgnoreLine}">
	    // @extensionScannerIgnoreLine
	    </f:if>    
        $this->{lowerCamelFieldName} = ${lowerCamelFieldName};
    }
!
</f:format.raw>     