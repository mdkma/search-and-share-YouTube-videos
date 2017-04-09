# Small Web App to Search, Sort and Share YouTube Videos
## A simple PHP web app enabling users to login via Facebook, search and sort videos and share videos to Facebook
## Author
Developed by Derek Mingyu MA, 14110562D

Website: http://derek.ma/
GitHub: https://github.com/derekmma

## Functions
### Login via Facebook
Go to http://localhost/14110562d/ click the link to log in with your facebook account. After that, your profile photo and name will be displayed.
### Search Videos by Keywords
Input the keywords in the text input box.
### Show Videos
Top 20 videos after sorting will be shown. For the publish time, the program will just show publishing date because specific time in a day is not useful to the users. When calculating the hot score, the date and time will all be counted.
### Sort Videos by Decreasing Like Count
Choose sort method by click the radio button. For some videos, the owner choose of hide the statistics of the video to the public, thus the _view count_, _like count_, _dislike count_, _comment count_ will not be shown. And these videos with hidden statistics will have low ranking in sorting.
### Sort Videos by Hot Content Score
The score will be shown under titles for each video. As said before, the videos with hidden statistics will have low ranking.

## Remarks
Web components and polymer are implemented in this web app. Please use this web app in the browser which support web components. All testings are done under Chrome 57. 


