.. include:: ../../Includes.txt

.. _graph:

=====
Graph
=====


======================================================= =========== ============== ==== ====
Property                                                Data type   Default        Plus Mvc
======================================================= =========== ============== ==== ====
:ref:`graph.graphTemplate`                              String                     Yes  Yes
:ref:`graph.tags`                                       String                     Yes  Yes
======================================================= =========== ============== ==== ====


.. _graph.graphTemplate:

graphTemplate
=============

.. container:: table-row

    Property
        graphTemplate
   
    Data type
        String
         
    Description
        File name of the XML template from the site root.


.. _graph.tags:

tags
====

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

   


