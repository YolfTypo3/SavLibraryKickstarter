.. include:: ../../../Includes.txt

.. _kickstarterMenu.documentationConfiguration:

===========================
Documentation Configuration
===========================

This item opens the form used to generate the documentation of the extension.

.. figure:: ../../../Images/UsersManualKickstarterMenuDocumentationConfiguration.png 

.. tip::
   
   Click on the icons at the right hand side of **Documentation Configuration**:
   
   - to access to this section of the documentation.
   - to save the configuration
   - to generate the extension.

- **Documentation title**: title which will be shown in the documenation.

- **GitHub Repository**: GitHub repository if any.

- **GitHub Branch**: GitHub branch if any. 

- **Project Contact**: contact for this project. 

- **Project Discussion**: URL of the project discussion, if any.

- **Project Home**: URL of the project home, if any.

- **Project Issues**: URL of the project issues, if any.

- **Project Repository**: URL of the project repository, if any.

- **Inter Sphinx Mapping**: use this field to define tags for 
  references to other documents. In the extension `sav_library_example0 
  <https://extensions.typo3.org/extension/sav_library_example0>`_ a tag 
  to the SAV Library Kickstarter is defined as follows.
  
  ::
  
     savlibrarykickstarter = https://docs.typo3.org/typo3cms/extensions/sav_library_kickstarter
     
  This tag is used in the introduction section as follows.
  
  ::
  
     ... read the :ref:`SAV Library Kickstarter tutorial section <savlibrarykickstarter:tutorial>` 

- **Extensions**: extensions that will be added in the **Settings.cfg** file.

- **Keep Settings.cfg file**: set this option if you **manually** modify
  the **Settings.cfg** file. It will prevent the SAV Library Kickstarter
  to rebuild it.
  
- **Add docker-compose.yml file**: set this option if you want to generate 
  the documentation on your server using **docker-compose** from your extension
  directory.  
  
  ::
  
     docker-compose run --rm t3docmake
     
  The **docker-compose.yml** is such that the documentationn will be 
  generated in the directory **typo3conf/Documentation** of your server.   



