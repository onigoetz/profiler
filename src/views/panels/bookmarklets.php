<h2>Bookmarks</h2>
<table>
    <thead>
        <tr>
            <th>CSS</th>
            <th>JavaScript</th>
            <th>Other</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <ul>
                    <li><a href="javascript:function bl_reloadCSS(){var%20qs='?'+new%20Date().getTime(),l,i=0;while (l=document.getElementsByTagName('link')[i++]){if(l.rel&amp;&amp;'stylesheet'==l.rel.toLowerCase()) {if(!l._h)l._h=l.href;l.href=l._h+qs}}}; bl_reloadCSS();">Reload CSS</a></li>
                    <li><a href="javascript:function%20loadScript(scriptURL)%20{%20var%20scriptElem%20=%20document.createElement('SCRIPT');%20scriptElem.setAttribute('language','JavaScript');%20scriptElem.setAttribute('src',%20scriptURL);%20document.body.appendChild(scriptElem);}loadScript('http://westciv.com/mri/theMRI.js');">MRI (Test CSS Selectors)</a></li>
                    <li><a href="javascript:s=document.getElementsByTagName('STYLE'); ex=document.getElementsByTagName('LINK'); d=window.open().document; /*set base href*/d.open();d.close(); b=d.body; function trim(s){return s.replace(/^\s*\n/, '').replace(/\s*$/, ''); }; function iff(a,b,c){return b?a+b+c:'';}function add(h){b.appendChild(h);} function makeTag(t){return d.createElement(t);} function makeText(tag,text){t=makeTag(tag);t.appendChild(d.createTextNode(text)); return t;} add(makeText('style', 'iframe{width:100%;height:18em;border:1px solid;')); add(makeText('h3', d.title='Style sheets in ' + location.href)); for (i=0; i<s.length; ++i) { add(makeText('h4','Inline style sheet'  + iff(' title=&quot;',s[i].title,'&quot;'))); add(makeText('pre', trim(s[i].innerHTML))); } for (i=0; i<ex.length; ++i) { rs=ex[i].rel.split(' '); for(j=0;j<rs.length;++j) if (rs[j].toLowerCase()=='stylesheet') { add(makeText('h4','link rel=&quot;' + ex[i].rel + '&quot; href=&quot;' + ex[i].href + '&quot;' + iff(' title=&quot;',ex[i].title,'&quot;'))); iframe=makeTag('iframe'); iframe.src=ex[i].href; add(iframe); break; } } void 0">View all CSS</a></li>
                    <li><a href='javascript:(function(){var a={},b=[],i,e,c,k,d,s="<table border=1><thead><tr><th>#</th><th>Tag</th><th>className</th></tr></thead>";for (i=0;e=document.getElementsByTagName("*")[i];++i)if (c=e.className) {k=e.tagName+"."+c;a[k]=a[k]?a[k]+1:1;}for(k in a)b.push([k,a[k]]);b.sort();for(i in b) s+="<tr><td>"+b[i][1]+"</td><td>"+b[i][0].split(".").join("</td><td>")+"</td></tr>";s+="</table>";d=open().document;d.write(s);d.close();})()'>View classes</a></li>
                </ul>
            </td>
            <td>
                <ul>
                    <li><a href="javascript:function%20loadScript(scriptURL)%20{%20var%20scriptElem%20=%20document.createElement('SCRIPT');%20scriptElem.setAttribute('language','JavaScript');%20scriptElem.setAttribute('src',scriptURL);%20document.body.appendChild(scriptElem);}loadScript('http://westciv.com/xray/thexray.js');">XRay</a></li>
                    <li><a href="javascript:prefFile='';void(z=document.body.appendChild(document.createElement('script')));void(z.language='javascript');void(z.type='text/javascript');void(z.src='http://slayeroffice.com/tools/modi/v2.0/modi_v2.0.js');void(z.id='modi');">DOM Inspector</a></li>
                    <li><a href="javascript:s=document.body.appendChild(document.createElement('script'));s.id='fs';s.language='javascript';void(s.src='http://slayeroffice.com/tools/suite/suite.js');">Favelet Suite</a></li>
                    <li><a href='javascript:function getSelSource() { x = document.createElement("div"); x.appendChild(window.getSelection().getRangeAt(0).cloneContents()); return x.innerHTML; } function makeHR() { return nd.createElement("hr"); } function makeParagraph(text) { p = nd.createElement("p"); p.appendChild(nd.createTextNode(text)); return p; } function makePre(text) { p = nd.createElement("pre"); p.appendChild(nd.createTextNode(text)); return p; } nd = window.open().document; ndb = nd.body; if (!window.getSelection || !window.getSelection().rangeCount || window.getSelection().getRangeAt(0).collapsed) { nd.title="Generated Source of: " + location.href; ndb.appendChild(makeParagraph("No selection, showing generated source of entire document.")); ndb.appendChild(makeHR()); ndb.appendChild(makePre("<html>\n" + document.documentElement.innerHTML + "\n</html>")); } else { nd.title="Partial Source of: " + location.href; ndb.appendChild(makePre(getSelSource())); }; void 0'>View Selected Source</a></li>
                    <li><a href="javascript:s=document.getElementsByTagName('SCRIPT'); d=window.open().document; /*140681*/d.open();d.close(); b=d.body; function trim(s){return s.replace(/^\s*\n/, '').replace(/\s*$/, ''); }; function add(h){b.appendChild(h);} function makeTag(t){return d.createElement(t);} function makeText(tag,text){t=makeTag(tag);t.appendChild(d.createTextNode(text)); return t;} add(makeText('style', 'iframe{width:100%;height:18em;border:1px solid;')); add(makeText('h3', d.title='Scripts in ' + location.href)); for (i=0; i<s.length; ++i) { if (s[i].src) { add(makeText('h4','script src=&quot;' + s[i].src + '&quot;')); iframe=makeTag('iframe'); iframe.src=s[i].src; add(iframe); } else { add(makeText('h4','Inline script')); add(makeText('pre', trim(s[i].innerHTML))); } } void 0">View all JS</a></li>
                    <li><a href='javascript:(function(){var x,d,i,v,st; x=open(); d=x.document; d.open(); function hE(s){s=s.replace(/&amp;/g,"&amp;amp;");s=s.replace(/>/g,"&amp;gt;");s=s.replace(/</g,"&amp;lt;");return s;} d.write("<style>td{vertical-align:top; white-space:pre; } table,td,th { border: 1px solid #ccc; } div.er { color:red }</style><table border=1><thead><tr><th>Variable</th><th>Type</th><th>Value as string</th></tr></thead>"); for (i in window) { if (!(i in x) ) { v=window[i]; d.write("<tr><td>" + hE(i) + "</td><td>" + hE(typeof(window[i])) + "</td><td>"); if (v===null) d.write("null"); else if (v===undefined) d.write("undefined"); else try {st=v.toString(); if (st.length)d.write(hE(v.toString())); else d.write("%C2%A0")} catch (er) {d.write("<div class=er>"+hE(er.toString())+"</div>")}; d.write("</pre></td></tr>"); } } d.write("</table>"); d.close(); })();'>View all vars/functions</a></li>
                </ul>
            </td>
            <td>
                <ul>
                    <li><a href="javascript:var i, bl_hidden = document.getElementsByTagName('input');for (i=0; i<bl_hidden.length; i++) {if (bl_hidden[i].type == 'hidden') {bl_hidden[i].type = 'text';}}">Show hidden inputs</a></li>
                    <li><a href="javascript: function injectCSS() {var style = document.createElement('STYLE');style.type = 'text/css';style.innerHTML = 'img[alt=\'\'] {border: 2px dotted red;} img:not([alt]) {border: 2px solid red;} img[title=\'\'] {outline: 2px dotted fuchsia;} img:not([title]) {outline: 2px solid fuchsia;}';document.getElementsByTagName('HEAD')[0].appendChild(style);} injectCSS()">Check Img Alt</a></li>
                    <li><a href="javascript:(function() {var%20el_to_remove=document.getElementById('pqp-container');el_to_remove.parentNode.removeChild(el_to_remove);var%20script=document.createElement('script');script.src='http://mir.aculo.us/dom-monster/dommonster.js?'+Math.floor((+new%20Date)/(864e5));document.body.appendChild(script);})()">Dom monster</a></li>
                </ul>
            </td>
        </tr>
        <tr>
            <th>CSS Files</th>
            <th>JS Files</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <td id="css_files_container">CSS Files</td>
            <td id="js_files_container">JS Files</td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>
