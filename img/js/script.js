const express = require("express");
const app = express();
const NewsAPI = require('newsapi');

//自分のAPIキーに置き換えてください
const newsapi = new NewsAPI('http://newsapi.org/v2/top-headlines?country=us&category=business&apiKey=21e125c7520d4e78b551f9f9d40daabe');

app.get("/", (req, res) => res.sendFile(__dirname + "/index.html"));

//News APIを利用してトップニュースを取得する
app.get("/data", (req, res) => {
  newsapi.v2.topHeadlines({
    country: 'jp',
    category: 'technology',
    pageSize: 40
  }).then(news => res.send(news));
});

app.listen(3000, () => console.log('listening on port ' + 3000));