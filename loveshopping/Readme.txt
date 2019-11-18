Readme file for project to scrape data from:https://www.julian-fashion.com/en-IT

1. FILES AND FOLDERS:

-config.json - this is the configuration file you need to open and setup before doing a scrape run
-proxies.csv - this is the file where you put in the proxies that will be used to scrape the website
-categoryURLS.json - this is the file where you can put cateogry urls of https://www.julian-fashion.com/en-IT. If they add any new categories not included in the list you can add them here. Try to put general categories that have the most products in them. Do not put subcategories as they are already included in the general categories to avoid scraping overhead.
-GetProductLists.R - this is the first script that you have to run in a scarape run. This script will get all categories, all pages in them and it will scrape all product links.
-runGetProducts.R - this is the main script that needs to make over 10.000 requests to scrape all the product data. 
-mergeData.R - this is a script you need to run after completing the scrape run. This will merge all product JSONs in ./products/ and output a file to main directory with name scraperun-[scraperunname]-data-[todays-date].json
-./products/ - in this folder every product is saved as separate JSON file. You might want to zip it and make a backup before deleting the contents of the folder before starting a new scrape run.
-/productslinks/ - here the lists of products are saved. Best not to tocuh this folder
-ProductListingPages.RDS - lists of pages of products, best not to touch this file.
-possiblybadproxies.csv - list of proxies that the script has discared and removed from proxies.csv as possibly blocked by the website. Theese might be reusable in the future, use your best judgment wheter to put them back in proxies.csv. You might save a few pennies, you might slow the script down. 

2.CONFIGURATION

Before doing anything make sure to open config.json and see what is in there. There are few items:
-numberOfSessions - this is the number of concurent HTTP sessions that you want to run to scrape the webpage. More sessions means faster scraping. Never launch more sessions then the number of proxies you have in proxies.csv. In fact, it's better if you always have less sessions then the number of proxies in proxies.csv. See more on this in proxy recyciling. Make sure to provide a number as it is formated in the config.json to avoid any errors.
-delayBetweenSessions - To avoid beeing blocked the script pauses from time to time. This is the avarage pause in seconds it takes before it makes another reqest form the same sessions/proxy/ip. I say it's avarage because there is a slight random compoenent to it. I put 7.5 seconds as suggestion, change if you have other preference.
-delayBetweenRequests - This is the delay beteween each request all the proxies/sessions together make. I put in 0.5 seconds as suggestion, change if you want, make sure it is a number.It is also avarage with a random componenet.
-SCRAPERUN_NAME - This is the name of the scrape run, it needs to be unique for every scrape run.You can put any string allowed to be used in filenames here.From the start to the time of completition you do not want to change this. You can always finish a scrape run later, or continue it if main scrip crashes.

3. PROXIES

Put proxies in the csv file separeted by commas in format 
ip,port,username,password

Proxies are recycled. Each time HTTP sessions are launched the first numberOfSessions proxies are taken from the top of the list and used. At the same time they are put at the botton of the list in the file, so they will be the last to be used again. This recyciling may allow you to use fixed number of fixed proxies instead of buying new ones every few scrape runs.

You want to have at least numberOfSessions proxies in the file. If you have less multiple requests will be send from the same IP and it won't be long before it is locked out.

Always ensure that you have more proxies in proxies.csv then you have concurent sessions.

From time to time the script will analyze sessions history of a given proxy and if that proxy keeps getting bad HTTP status codes or fails to deliver it will be discared, removed from proxies.csv and put in a file possiblybadproxies.csv. You might want to review it form time to time and see if any of the proxies can be reused. Best to check manually if you can open the website with that proxy.

4. RUNNING IT

After I set the enviroment for , all you have to do is run the script in follwing order:
1. First check if you have any files in ./products/ folder and zip them as backup or delete them. You must remove all ~10.000 files from this folder before doing a scrape run.
2. Next check config.json and categoryURLS.json. Make sure everything looks good there. Make sure to give the scrape run a unique name.
3. Next is to check proxies.csv and make sure you have enough proxies, they should be at least as the number of conncurent sessions you intend to run.
4. Next in consloe run Rscript GerProductLists.R . This is a short script that will get all product links. Once it completes sucesfully you can go to next step.
3. Now you need to run the main script which will scrape all product data.
Run Rscript runGetProducts.R in console and it will start scraping. If it finds a bad URL, can't get product data it should continue by just skipping that product, however in case it crashes, just re-run it without changing SCARPERUN_NAME config.json and it should continue where it left off.
4. Finanly if you are happy with all the files the script put in ./products/ you can merge them in one JSON. Run Rscript mergeData.R and it should put them in a file for you in main directory with name scraperun-[SCRAPERUN_NAME]-data-[MERGE-DATE].json


