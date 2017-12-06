{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}

@return <f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Types/{field.type}.t', default:'Partials/Model/Types/Default.t')}" arguments="{_all}" />
