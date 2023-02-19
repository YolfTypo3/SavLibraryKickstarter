{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}

<f:if condition="{field.conf_override_type}">
<f:then><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Types/{field.conf_render_type}.t', default:'Partials/Model/Types/Default.t')}" arguments="{_all}" /></f:then>
<f:else>string</f:else>
</f:if>