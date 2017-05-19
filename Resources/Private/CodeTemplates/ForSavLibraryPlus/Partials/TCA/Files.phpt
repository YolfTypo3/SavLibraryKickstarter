{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}
'config' => [
    'type' => 'group',
    'internal_type' => 'file',
    <f:alias map="{images:'images', webimages:'webimages', all:'all'}">
    <f:if condition="{field.conf_files_type} == {all}">
      <f:then>
    'allowed' => '',
    'disallowed' => 'php,php3',
      </f:then>
      <f:else>
        <f:if condition="{field.conf_files_type} == {images}">
          <f:then>
    'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
          </f:then>
          <f:else>
            <f:if condition="{field.conf_files_type} == {webimages}">
              <f:then>
    'allowed' => 'gif,png,jpeg,jpg',
              </f:then>
              <f:else>
    'allowed' => '',
    'disallowed' => 'php,php3',
              </f:else>
            </f:if>
          </f:else>
       </f:if>
      </f:else>
    </f:if>
    </f:alias>
    'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
    'uploadfolder' => 'uploads/tx_{sav:function(name:"removeUnderscore", arguments:"{extension.general.1.extensionKey}")}',
    'size' => {f:if(condition:'{field.conf_files_selsize}',then:'{field.conf_files_selsize}',else:'1')},
    'minitems' => 0,
    'maxitems' => {f:if(condition:'{field.conf_files}',then:'{field.conf_files}',else:'1')},
],