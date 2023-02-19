{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}

<f:spaceless>
<f:if condition="{field.conf_custom_model_name}">
    <f:then>
{field.conf_custom_model_name}
    </f:then>
    <f:else>
<f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/TCA/EXTForeignModel/{field.conf_render_type}.t', default:'Partials/TCA/EXTForeignModel/Default.t')}" arguments="{_all}" />
    </f:else>
</f:if>
</f:spaceless> 