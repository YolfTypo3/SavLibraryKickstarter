{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}

@param <f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Types/{field.type}.t', default:'Partials/Model/Types/Default.t')}" arguments="{_all}" /> ${field.fieldname}