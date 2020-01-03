from selenium import webdriver
import time
# in this file we will test the workflow of a teacher 

url = 'http://localhost:8080/'

options = webdriver.ChromeOptions()
options.add_argument('--disable-web-security')

# add the allow cors extension 
options.add_extension('./extension_0_1_2_0.crx')

# you need to install the chrome driver if you are using linux 
#if you are using windows you can use this driver webdriver.Chrome("./chromedriver") 

driver = webdriver.Chrome(chrome_options = options)
driver.get(url)

time.sleep(3)
# find commencer button and click on it 
commencerBtn = driver.find_element_by_xpath('//button[text()="Commencer"]')
commencerBtn.click()
time.sleep(3)
# we will be redirected to the login page 

###### Login part #####
driver.find_element_by_id("exampleInputEmail1").send_keys("y.boutouchent@esi-sba.dz")
driver.find_element_by_id("exampleInputPassword1").send_keys("Password")

login_button = driver.find_element_by_xpath('//button[text()="Se connecter"]')
login_button.click()


time.sleep(5)

## now we are redirected to the module page 
### Module Page ##
groupe_link = driver.find_element_by_xpath('//a[text()="1CS g3"]')
groupe_link.click()
time.sleep(3)

## now we will see that the students notes are printed
moy = driver.find_element_by_xpath('//*[@id="app"]/div/div/div/div[2]/table/tbody/tr[1]/td[6]').text

CC = driver.find_element_by_xpath('//*[@id="app"]/div/div/div/div[2]/table/tbody/tr[1]/td[3]/input')
value = float(CC.get_attribute('value'))+3.0
CC.clear()
CC.send_keys(str(value))
CC.send_keys(u'\ue007')
time.sleep(4)

groupe_link = driver.find_element_by_xpath('//a[text()="1CS g2"]')
groupe_link.click()
time.sleep(3)
groupe_link = driver.find_element_by_xpath('//a[text()="1CS g3"]')
groupe_link.click()
time.sleep(3)

newMoy=driver.find_element_by_xpath('//*[@id="app"]/div/div/div/div[2]/table/tbody/tr[1]/td[6]').text
if(float(newMoy) == float(moy)+1 ):
	print("Test Passed Successfully")



