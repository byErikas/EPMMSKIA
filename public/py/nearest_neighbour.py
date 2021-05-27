import sys
import pandas as pd
import mysql.connector as connection
from more_itertools import take
from surprise import Reader, Dataset
from surprise import KNNWithMeans

try:
    mydb = connection.connect(
        host="filmtestdata.northeurope.cloudapp.azure.com", database='laravel8-shop', user="pard", passwd="Erikutiss19", use_pure=True)
    query = "Select * from ratings;"
    ds_ratings = pd.read_sql(query, mydb)
    query = "Select * from products;"
    ds_products = pd.read_sql(query, mydb)
    mydb.close()  # close the connection
except Exception as e:
    mydb.close()
    print(str(e))

# DATA TABLE - RATINGS
df = pd.DataFrame(ds_ratings)
df_item = pd.DataFrame(ds_products)
df_users = df['user_id'].astype(int)
df_reshaped = df[['user_id', 'rateable_id', 'rating']].copy()
df_reshaped = df_reshaped.apply(pd.to_numeric)

counter = 0
for row in df_users:
    if(row == int(sys.argv[1])):
        counter += 1

if (counter < 3):
    print("NAN")
else:
    # To use item-based cosine similarity
    sim_options = {
        "name": "cosine",
        "min_support": 3,
        "user_based":  True,
    }

    algo = KNNWithMeans(sim_options=sim_options, verbose=True)
    reader = Reader(rating_scale=(1, 5))
    data = Dataset.load_from_df(df_reshaped, reader)
    trainingSet = data.build_full_trainset()
    algo.fit(trainingSet)
    array = ds_products['id']
    pred = {}
    for index, row in df_item.iterrows():
        prediction = algo.predict(int(sys.argv[1]), int(row['id']))
        pred.update({row['id']: prediction.est})

    sorted_d = dict(
        sorted(pred.items(), key=lambda item: item[1], reverse=True))

    n_items = take(int(sys.argv[2]), sorted_d.items())
    for item in n_items:
        print(item[0], item[1])
