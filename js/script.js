let http = {
    get : function(url, callback = function(e) {console.log(e)} ) {
        let xmlHttp = new XMLHttpRequest();
    
        xmlHttp.onreadystatechange = function() { 
            if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
                callback(xmlHttp.responseText);
        }
    
        xmlHttp.open("GET", url, true);
    
        xmlHttp.send();
    },

    post : function(url, data, callback = function(e) {console.log(e)} ) {
        let xmlHttp = new XMLHttpRequest();

        xmlHttp.onreadystatechange = function() { 
            if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
                callback(xmlHttp.responseText);
        }

        data = JSON.stringify(data);

        xmlHttp.open("POST", url, true);
        xmlHttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');

        xmlHttp.send(data);        
    }
};

const url = '/php/logic';

function clearData() {
    http.post(url, {action: 'clear'}, r => {
        console.log(r);
        let t = document.createElement('p');
        t.appendChild(document.createTextNode(r));
        document.querySelector('#pc').appendChild(t);
    });
}

function updateData() {
    http.post(url, {action: 'update'}, r => {
        console.log(r);
        let t = document.createElement('p');
        t.appendChild(document.createTextNode(r));
        document.querySelector('#pc').appendChild(t);
    });
}

function findPosts(keyword) {
    let sr = document.querySelector('.search-result');
    sr.innerHTML = '';

    http.post(url, {action: 'find_posts', keyword: keyword}, r => {
        let posts = JSON.parse(r)
        console.log(posts);

        if (posts.length != 0){

            posts.forEach(async e => {
                let p = document.createElement('div');
                p.className = 'post';
    
                let pt = document.createElement('div');
                pt.className = 'post-title';
                pt.innerHTML = e.title;
                p.appendChild(pt);
                
                let pc = document.createElement('div');
                pc.className = 'post-comments';
    
                e.comments.forEach(j => {
                    let c = document.createElement('div');
                    c.className = 'post-comment';
    
                    let ct = document.createElement('div');
                    ct.className = 'comment-title';
                    ct.innerHTML = '<span>' + j.name + '</span><span>&nbsp;|&nbsp;</span><span>' + j.email + '</span>';
                    c.appendChild(ct);
    
                    let cb = document.createElement('div');
                    cb.className = 'comment-body';
                    cb.innerHTML = '<p>' + j.body.replaceAll('\n', '<br>').replaceAll(keyword, '<span class="select">' + keyword + '</span>') + '</p>';
                    c.appendChild(cb);
    
                    pc.appendChild(c);
                });
                p.appendChild(pc);
    
                sr.appendChild(p);
            });
        } else {
            sr.innerHTML = 'Ничего не найдено';
        }


    });
}

document.addEventListener('DOMContentLoaded', async () => {
    
    document.querySelectorAll('.on-click').forEach(e => {
        e.addEventListener('click', () => {
            window[e.getAttribute('action')]();
        })
    });

    if (document.querySelector('#ff')) {
        let f = document.querySelector('#ff');
        f.addEventListener('submit', e => {
            e.preventDefault();
            let k = f.firstChild.nextSibling;

            if (k.value.length >= 3) {
                k.classList.remove('error');

                findPosts(k.value);
                
            } else {
                k.classList.add('error');
            }
        });
    }
    
    console.log('ready');
});