'config' => [
    <f:if condition ="{extension.general.1.compatibility} < '12x'">
    <f:then>
    'type'  => 'input',
    'eval'  => 'double2',
    'size'  => 6,
    'default' => 0    
    </f:then>
    
    <f:else>
    'type' => 'number',
    'format' => 'decimal',
    'size'  => 6,
    'default' => 0    
    </f:else>
    </f:if>
],