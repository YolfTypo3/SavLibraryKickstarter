<f:format.raw>   
    /**
     * Getter for property <{lowerCamelFieldName}>.
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function get{upperCamelFieldName}(): ?\TYPO3\CMS\Extbase\Persistence\ObjectStorage
    {
        return $this->{lowerCamelFieldName};
    }
!
    /**
     * Setter for property <{lowerCamelFieldName}>.
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage ${lowerCamelFieldName}
     * @return void
     */
    public function set{upperCamelFieldName}(\TYPO3\CMS\Extbase\Persistence\ObjectStorage ${lowerCamelFieldName})
    {
        $this->repository ??= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\{vendorName}\{extensionName}\Domain\Repository\{modelName}Repository::class);
        $fieldConfiguration = $this->repository->getDataMapFactory()->getSavLibraryMvcFieldConfiguration('{field.fieldname}');
        $this->{lowerCamelFieldName} = $this->updateFileStorage($this->{lowerCamelFieldName}, ${lowerCamelFieldName}, $fieldConfiguration);
    }
!
</f:format.raw>  