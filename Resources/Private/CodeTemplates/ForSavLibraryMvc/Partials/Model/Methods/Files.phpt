<f:format.raw>   
    /**
     * Getter for property <{lowerCamelFieldName}>.
     *
     * @return ObjectStorage
     */
    public function get{upperCamelFieldName}(): ?ObjectStorage
    {
        return $this->{lowerCamelFieldName};
    }
!
    /**
     * Setter for property <{lowerCamelFieldName}>.
     *
     * @param ObjectStorage ${lowerCamelFieldName}
     * @return void
     */
    public function set{upperCamelFieldName}(ObjectStorage ${lowerCamelFieldName}): void
    {
        $this->{lowerCamelFieldName} = ${lowerCamelFieldName};
    }   
!
</f:format.raw>  