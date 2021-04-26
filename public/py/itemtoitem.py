import pandas as pd
import sys
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import linear_kernel
ds = pd.read_csv('products.csv')

tf = TfidfVectorizer(analyzer='word', ngram_range=(1, 3),
                     min_df=0, stop_words='english')
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
    recs = results[item_id][:num]
    for rec in recs:
        print(str(item(rec[1])))


recommend(int(sys.argv[1]), int(sys.argv[2]))
