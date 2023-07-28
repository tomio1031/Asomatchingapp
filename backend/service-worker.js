// キャッシュしたいファイルの一覧を指定
const cacheFiles = ['http://learning-sql.kikirara.jp/chat_history.html', 'http://learning-sql.kikirara.jp/chat.html','http://learning-sql.kikirara.jp/create.html','http://learning-sql.kikirara.jp/historyy.html','http://learning-sql.kikirara.jp/home.html','http://learning-sql.kikirara.jp/login.html','http://learning-sql.kikirara.jp/profile_editt.html','http://learning-sql.kikirara.jp/profilee.html'];
const cacheName = 'v1';

// インストール時に実行されるイベント
self.addEventListener('install', event => {
  // キャッシュしたいファイルを指定
  caches.open(cacheName).then(cache => cache.addAll(cacheFiles));
});

// インストール後に実行されるイベント
self.addEventListener('activate', event => {
  // 必要に応じて古いキャッシュの削除処理などを行う
});

// fetchイベント
self.addEventListener('fetch', event => {
  // キャッシュがあればそれを返す
  event.respondWith(
    caches.match(event.request).then(function(resp) {
      return resp || fetch(event.request).then(function(response) {
        let responseClone = response.clone();
        caches.open(cacheName).then(function(cache) {
          cache.put(event.request, responseClone);
        });
        return response;
      });
    }).catch(function() {
      return caches.match('https://ds-b.jp/media/files/libs/26307/p/202209211052133322.jpg?1663725136');
    })
  );
});
