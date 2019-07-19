.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
  :class:  typoscript
.. role::   php(code)


Graph
-----


======================================================= =========== ============== ==== ====
Property                                                Data type   Default        Plus Mvc
======================================================= =========== ============== ==== ====
:ref:`Graph.graphTemplate`                              String                     Yes  Yes
:ref:`Graph.tags`                                       String                     Yes  Yes
======================================================= =========== ============== ==== ====


.. _Graph.graphTemplate:

graphTemplate
^^^^^^^^^^^^^

.. container:: table-row

    Property
        graphTemplate
   
    Data type
        String
         
    Description
        File name of the XML template from the site root.


.. _Graph.tags:

tags
^^^^

.. container:: table-row

    Property
        tags
   
    Data type
         String  
              
    Description
        Comma-separated list of definitions. Example: “marker#begin =
        ###beginPeriod###” means that the “marker” whose id is “begin” in the
        template will be replaced by the marker “###beginPeriod###”, that is
        by the alias “beginPeriod”.
        
        .. note::
        
            Since SAV Library Kickstarter 1.2.0, the property "tags" replaces the former property "markers".

   


