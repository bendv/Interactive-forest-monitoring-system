# Design and implementation of an interactive web-based near real-time forest monitoring system
Data and code accompanying the paper:

Pratihast A.K., DeVries, B., Avitabile, V., de Bruin, S., Herold, M., &amp; Bergsma, A. Design and implementation of an interactive web-based near real-time forest monitoring system PLoS ONE, in review 

# Introduction
This paper describes an interactive web-based near real-time (NRT) forest monitoring system using four levels of geographic information services: 1) the acquisition of continuous data streams from satellite and community-based monitoring using mobile devices, 2) NRT forest disturbance detection based on satellite time-series, 3) presentation of forest disturbance data through a web-based
application.


# Community-based forest monioting 
Data entry form was designed using open data kit (ODK).The form rendered on an Android platform through ODK Collect, which allows multiple data records to be entered (text variables, GPS position, photo etc.) and stored on a mobile device. After data collection, users transfered the collected data to the database server

1) ODK Form used for forest disturbance monioting in Ethiopia is stored in CBM/Form 
2) Saple data collected through ODK form is stiored in CBM/Data 


# Landsat image time-series analysis
Following semi-automated process chain was developed to download, store and process Landsat image time-series. 
1) Download the data: All the historic as well as continuously acquired Landsat TM, ETM+ and OLI surface reflectance images with WRS-2 coordinates path 170 and row 55 at processing level LT1 were obtained from the United States Geological Survey (USGS) Earth Resources Observation and Science (EROS) Center Science Processing Architecture (ESPA, http://espa.cr.usgs.gov). 
2) Pre-processing : After downloading the Landsat data, multiple pre-processing steps were applied: application of the FMASK algorithm for cloud masking, computation of NDVI and application of a forest mask. 
3) Change detection : We used the BFAST Monitor method for breakpoint detection in Landsat NDVI time-series images for NRT forest change detection. 


# Spatial database structure
software : PostGre SQL 
1)community-based monioting data 
2)sattelite based forest change alert 

# Web mapping 

Software used 
-Apache
-GeoServer
-OpenLayers
-jQuery 
-PhP



