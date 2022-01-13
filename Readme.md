## About 
Searching by keywords in News Articles becomes quite a necessity given the importance of time taken to search the right topic for a reader. With a search tool for News Articles, the reader could just search for the right articles with important information hassle free. With this project we plan to implement a search tool for Indian News Articles (using a news articles dataset taken from the Internet), based on multithreading with the help of OpenMP


## Data
Indian News Articles Dataset (from Kaggle). This dataset contains various Indian news articles from multiple sources like Firstpost.com, ndtv.com etc. The main column of this dataset which will be needed for this project is the ‘content’ column.

## Execution
1. Execute convert.py to convert data from the dataset into files.
2. Make use of the cpp file to generate the SQL insert commands.
![CPP Execution](img/3.png?raw=true "CPP Execution" width="200" height="100")
4. Open display.php in your XAMPP server on PhpMyAdmin.
![display.php](img/1.png?raw=true "Display Interface" width="200" height="100")
6. Word Searching(with frequency) throughout the articles is ready to be used.
![display.php](img/2.png?raw=true "Search Results" width="200" height="100")

## Parallelization
![Compare](img/4.png?raw=true "Comparison" width="200" height="100")

The above graph shows the time taken for the execution of storing and searching of keywords using different numbers of threads. From the graph, it is evident that the performance (in terms of execution time) when only one thread is employed for the task is much worse (1.53 seconds) as compared to that when multiple threads are used. For 2, 4 and 8 threads, the execution time comes out to be around 0.04, 0.028 and 0.017 seconds respectively. As expected, the execution time decreases with an increase in the number of threads.

## Future Work
Currently this application is not hosted on cloud, works locally with the dependencies of OpenMP being installed prior to usage, so we plan to host this on cloud. Better resource management through the use of a hybrid OpenMP + MPI architecture instead of a standalone OpenMP application is one of the ideas we have envisioned for this application.

## Contributors
<a href="https://github.com/avats101/ParallelNewsSearch/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=avats101/ParallelNewsSearch" />
</a>
