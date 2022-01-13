# importing pandas library to load the historic articles dataset
import pandas as pd

#loading the dataset and converting the content column into list 'a'
df = pd.read_csv('historic_articles.csv')
a = list(df['content'])

#write five articles from the content column to text files
for i in range(1, 6):
    file = open("File"+str(i)+".txt", "w")
    file.writelines(a[i])
    file.close()
