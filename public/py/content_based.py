import mysql.connector as connection
import pandas as pd
import sys
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import linear_kernel

try:
    mydb = connection.connect(
        host="filmtestdata.northeurope.cloudapp.azure.com", database='laravel8-shop', user="pard", passwd="Erikutiss19", use_pure=True)
    query = "Select * from products;"
    ds = pd.read_sql(query, mydb)
    mydb.close()  # close the connection
except Exception as e:
    mydb.close()
    print(str(e))

words = ["ir", "ar", "arba", "nes"]

tf = TfidfVectorizer(analyzer='word', ngram_range=(1, 3),
                     min_df=0, stop_words=words)
tfidf_matrix = tf.fit_transform(ds['description'])

cosine_similarities = linear_kernel(tfidf_matrix, tfidf_matrix)
results = {}
for idx, row in ds.iterrows():
    similar_indices = cosine_similarities[idx].argsort()[:-100:-1]
    similar_items = [(cosine_similarities[idx][i], ds['id'][i])
                     for i in similar_indices]
    results[row['id']] = similar_items[1:]

    def item(id):
        return ds.loc[ds['id'] == id]['id'].tolist()[0]


def recommend(item_id, num):
    duplicate = False
    recs = results[item_id][:num+1]
    for val in recs:
        if(val[1] == item_id):
            recs.remove(val)
            duplicate = True

    if(duplicate == False):
        recs = recs[:-1]

    for rec in recs:
        print(str(item(rec[1])))


recommend(int(sys.argv[1]), int(sys.argv[2]))
