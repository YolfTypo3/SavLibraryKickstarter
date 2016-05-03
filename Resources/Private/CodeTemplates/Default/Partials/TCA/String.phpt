'config' => array(
    'type' => 'input',
    'size' => '{f:if(condition:field.conf_size,then:field.conf_size,else:30)}',
    'eval' => 'trim<f:if condition="{field.conf_required}">,required</f:if>'
),