{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}

<f:if condition="{field.conf_override_type}">
<f:then><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/ValidationRules/PhpDoc/{field.conf_render_type}.t', default:'Partials/Model/ValidationRules/PhpDoc/Default.t')}" arguments="{_all}" /></f:then>
<f:else>No Validation</f:else>
</f:if>