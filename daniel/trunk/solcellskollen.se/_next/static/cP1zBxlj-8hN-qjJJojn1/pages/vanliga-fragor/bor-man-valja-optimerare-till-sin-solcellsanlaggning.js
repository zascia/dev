(window.webpackJsonp=window.webpackJsonp||[]).push([[120],{"5IRY":function(e,t,n){"use strict";var a=n("0iUn"),r=n("sLSF"),l=n("MI3g"),i=n("a7VT"),o=n("Tit0"),s=n("kOwS"),c=n("q1tI"),p=n.n(c),m=n("E/Ix"),g=n("TNUr"),d=n("vZU/"),u=n("cSx4"),v=p.a.createElement,f={h3:function(e){return v(d.p,Object(s.a)({fontFamily:"medium",mb:3},e))},h5:d.f,p:d.k,a:d.a,em:d.m,strong:d.l,li:function(e){return v(d.w,Object(s.a)({mb:2,fontSize:[2,3,3],color:"near-black",fontFamily:"book",maxWidth:"normal",fontWeight:"normal",lineHeight:"copy",css:{listStyleType:"disc"}},e))},ul:d.h,ol:d.x,img:d.g};t.a=function(e){var t=e.title,n=e.description;return function(e){return function(s){function c(){return Object(a.a)(this,c),Object(l.a)(this,Object(i.a)(c).apply(this,arguments))}return Object(o.a)(c,s),Object(r.a)(c,[{key:"render",value:function(){return v(m.a,{components:function(e){return f}},v(g.a,{posts:u.questions,title:t,description:n},v(e,this.props)))}}]),c}(p.a.Component)}}},BZnI:function(e,t,n){"use strict";var a=n("q1tI"),r=n.n(a),l=n("m/Pd"),i=n.n(l),o=n("17x9"),s=n.n(o),c=r.a.createElement;s.a.string,t.a=function(e){var t=e.title,n=e.description,a=e.imageSrc,r=e.imageAlt,l=e.shareUrl;return c(i.a,null,c("title",null,t),c("meta",{name:"title",content:t}),c("meta",{name:"description",content:n}),function(e){var t=e.card,n=e.url,a=e.description;return[{name:"twitter:card",content:t},{name:"twitter:url",content:n},{name:"twitter:title",content:e.title},{name:"twitter:description",content:a},{name:"twitter:image",content:e.imageSrc},{name:"twitter:image:alt",content:e.imageAlt}]}({card:"summary_large_image",url:l,title:t,description:n,imageSrc:a,imageAlt:r}).map(function(e,t){var n=e.name,a=e.content;return c("meta",{name:n,content:a,key:"twitter-meta-tag-".concat(t)})}),function(e){var t=e.url,n=e.title,a=e.imageSrc,r=e.imageAlt,l=(e.imageType,e.imageWidth),i=e.imageHeight,o=e.description;return e.appId,[{property:"og:type",content:e.type},{property:"og:url",content:t},{property:"og:title",content:n},{property:"og:description",content:o},{property:"og:image",content:a},{property:"og:image:width",content:l},{property:"og:image:height",content:i},{property:"og:image:alt",content:r},{property:"og:locale",content:e.locale}]}({type:"website",url:l,title:t,description:n,imageSrc:a,imageAlt:r,imageWidth:480,imageHeight:480,locale:"sv_SE"}).map(function(e,t){var n=e.property,a=e.content;return c("meta",{property:n,content:a,key:"facebook-meta-tag-".concat(t)})}))}},TNUr:function(e,t,n){"use strict";var a=n("q1tI"),r=n.n(a),l=n("YFqc"),i=n.n(l),o=n("oDcX"),s=n("AKsT"),c=n("y/V6"),p=n("mkIq"),m=n("vZU/"),g=n("BZnI"),d=n("d9hK"),u=n("2O1n"),v=r.a.createElement;t.a=function(e){var t=e.posts,n=e.description,a=e.title,l=e.children,i=a||"Vanliga fr\xe5gor inf\xf6r ett solcellsk\xf6p",b=n||"Hur mycket solceller b\xf6r du installera? Vad kostar solceller? Och vad \xe4r en vanlig \xe5terbetalningstid? L\xe4s svaren p\xe5 de vanligaste fr\xe5gorna som uppst\xe5r inf\xf6r ett solcellsk\xf6p.";return v(r.a.Fragment,null,v(g.a,{title:"".concat(i," - Solcellskollen"),description:b,imageSrc:p.a.share.faq.src,imageAlt:p.a.share.faq.alt,shareUrl:"".concat("https://www.solcellskollen.se","/vanliga-fragor/").concat(Object(d.d)(i))}),v(o.a,{title:"Vanliga fr\xe5gor inf\xf6r ett solcellsk\xf6p",paragraph:"Om du inte hittar just din fr\xe5ga f\xe5r du g\xe4rna skriva i chatten nere till h\xf6ger.",img:p.a.illuFAQ,bgColor:"green"}),v(m.b,{mt:[4,5,5],mb:[4,0],mx:[2,"auto"],maxWidth:848},v(m.v,null,t.map(function(e,n){var a=e.title,r=e.updatedAt,o=Object(d.d)(a),s=o===Object(d.d)(i);return v(m.w,{key:o,css:{listStyleType:"none"}},v(f,{isOpen:s,slug:o,lastItem:n===t.length-1,title:a}),v(m.b,{px:2,mb:[3,4,4],display:s?"block":"none"},l,r&&v(m.D,{timestamp:new Date(r).toISOString()},v(m.m,{color:"near-black",fontSize:[1,2,2]},"Svar uppdaterat den ",Object(u.a)(r)))))}))),v(m.b,{display:["none","block"]},v(s.a,{bgColor:"white",text:"Skriv upp dig f\xf6r v\xe5rt m\xe5nadsbrev f\xf6r att h\xf6ra n\xe4r det h\xe4nder saker p\xe5 solcellsomr\xe5det!"})),v(m.b,{mt:5},v(c.a,null)))};var f=function(e){var t=e.isOpen,n=e.slug,a=e.lastItem,r=e.title;return v(i.a,{href:t?"/vanliga-fragor":"/vanliga-fragor/".concat(n),scroll:!1,passHref:!0},v(m.a,{textDecoration:"none"},v(m.b,{display:"flex",alignItems:"center",justifyContent:"space-between",px:2,py:[3,"20px","20px"],borderBottom:a?"none":"2px solid",borderColor:t?"transparent":"black-05",css:{"&:hover":{backgroundColor:m.F.colors["black-025"]}}},v(m.p,{mb:0,fontFamily:"medium"},r),v(m.r,t?{variant:"chevron-up",width:24,height:24,fill:"#a69e9d"}:{variant:"chevron-down",width:24,height:24,fill:"#a69e9d"}))))}},cSx4:function(e,t){e.exports={questions:[{title:"Hur stor yta kr\xe4ver solceller?",updatedAt:155652744e4},{title:"Hur mycket solceller b\xf6r jag installera?",updatedAt:1553589342e3},{title:"Vad kostar solceller?",updatedAt:1565179166e3},{title:"Vad \xe4r \xe5terbetalningstiden f\xf6r solceller?",updatedAt:1553589342e3},{title:"Hur l\xe4nge h\xe5ller solceller?",updatedAt:1553589342e3},{title:"Vilken lutning och v\xe4derstreck \xe4r b\xe4st f\xf6r solceller?",updatedAt:1553589342e3},{title:"Vilka bidrag finns det f\xf6r solceller?",updatedAt:1568295e6},{title:"N\xe4r \xe4r solceller ingen bra id\xe9?",updatedAt:1553589342e3},{title:"Vilka solpaneler ska man v\xe4lja?",updatedAt:1553589342e3},{title:"Vilken v\xe4xelriktare ska man v\xe4lja?",updatedAt:1553589342e3},{title:"B\xf6r man v\xe4lja optimerare till sin solcellsanl\xe4ggning?",updatedAt:1553589342e3},{title:"Kan man s\xe4lja solel?",updatedAt:1553589342e3},{title:"Vilket elbolag betalar b\xe4st f\xf6r solelen?",updatedAt:1553589342e3},{title:"Kan man lagra solel?",updatedAt:1553589342e3},{title:"K\xf6pa solceller nu eller v\xe4nta?",updatedAt:1554197644e3},{title:"L\xf6nar det sig att v\xe4lja ett integrerat solcellstak?",updatedAt:1556867937e3},{title:"Beh\xf6ver man bygglov f\xf6r att installera solceller?",updatedAt:1553589342e3},{title:"Vilka administrativa steg kr\xe4vs f\xf6r en installation?",updatedAt:1553589342e3},{title:"\xc4r solceller milj\xf6v\xe4nliga?",updatedAt:1553589342e3},{title:"Vad h\xe4nder n\xe4r jag ber om offert p\xe5 Solcellskollen?",updatedAt:1553589342e3},{title:"Vilka leverant\xf6rer syns p\xe5 Solcellskollen?"},{title:"Hur fungerar Solcellskollens ber\xe4kningar?"}]}},oDcX:function(e,t,n){"use strict";var a=n("0iUn"),r=n("sLSF"),l=n("MI3g"),i=n("a7VT"),o=n("Tit0"),s=n("q1tI"),c=n.n(s),p=n("17x9"),m=n.n(p),g=n("vZU/"),d=n("LNfz"),u=c.a.createElement,v=(m.a.object,m.a.oneOf,m.a.string,function(e){function t(){return Object(a.a)(this,t),Object(l.a)(this,Object(i.a)(t).apply(this,arguments))}return Object(o.a)(t,e),Object(r.a)(t,[{key:"render",value:function(){var e=this.props,t=e.img,n=e.paragraph,a=e.title,r=e.bgColor;return u("div",{className:"bg-".concat(r)},u("div",{className:"ph3 ph0-l pv4 pv5-ns mw8-ns center flex flex-column flex-row-ns justify-between items-center"},u("div",{className:"measure tc tl-ns order-1"},u(g.n,null,a),u("p",{className:"f5 f4-ns futura-book lh-copy measure"},n)),u(d.b,{width:192,className:"pt0 pb4 pb0-ns db w4 w5-ns order-2-ns",src:t.src,htmlAttributes:{alt:t.alt}})))}}]),t}(c.a.Component));t.a=v},smcd:function(e,t,n){(window.__NEXT_P=window.__NEXT_P||[]).push(["/vanliga-fragor/bor-man-valja-optimerare-till-sin-solcellsanlaggning",function(){var e=n("spLP");return{page:e.default||e}}])},spLP:function(e,t,n){"use strict";n.r(t),n.d(t,"meta",function(){return c}),n.d(t,"default",function(){return g});var a=n("kOwS"),r=n("qNsG"),l=n("q1tI"),i=n.n(l),o=n("E/Ix"),s=n("5IRY"),c=(i.a.createElement,{title:"B\xf6r man v\xe4lja optimerare till sin solcellsanl\xe4ggning?",description:"Det finns inget entydigt p\xe5 fr\xe5gan om och n\xe4r man b\xf6r v\xe4lja optimerare till sin anl\xe4ggning, d\xe4remot situationer d\xe5 det \xe4r extra l\xe4mpligt. Optimerare \xe4r exempelvis v\xe4l l\xe4mpade om man har ett tak d\xe4r solpaneler sitter i m\xe5nga olika lutningar och v\xe4derstreck, alternativt om vissa av panelerna \xe4r utsatta f\xf6r skugga relativt ofta."}),p={meta:c},m=Object(s.a)(c)(function(e){var t=e.children;return Object(o.b)(i.a.Fragment,null," ",t)});function g(e){var t=e.components,n=Object(r.a)(e,["components"]);return Object(o.b)(m,Object(a.a)({},p,n,{components:t,mdxType:"MDXLayout"}),Object(o.b)("p",null,"N\xe5got som blir allt vanligare som tillval till solcellssystem \xe4r s.k. optimerare. De \xe4r elektroniska komponenter som s\xe4tts p\xe5 en solpanel f\xf6r att maximera dess elproduktion och g\xf6ra den mindre beroende av produktionen i \xf6vriga paneler (vilket t.ex. \xe4r en f\xf6rdel om vissa paneler \xe4r skuggade). "),Object(o.b)("p",null,"Genom att man styr varje panel var f\xf6r sig kommer \xe4ven andra f\xf6rdelar, t.ex. att man kan \xf6vervaka elproduktionen i varje panel samt att sp\xe4nningen fr\xe5n solpanelerna kan g\xe5 ner till en ofarlig niv\xe5 om v\xe4xelriktaren st\xe4ngs av. Nackdelar \xe4r att det tillkommer en kostnad f\xf6r optimerarna och att anl\xe4ggningen blir mer komplex med eventuellt mer underh\xe5ll som f\xf6ljd. "),Object(o.b)("p",null,"Det finns inget entydigt p\xe5 fr\xe5gan om och n\xe4r man b\xf6r v\xe4lja optimerare till sin anl\xe4ggning, d\xe4remot situationer d\xe5 det \xe4r extra l\xe4mpligt. Optimerare \xe4r exempelvis v\xe4l l\xe4mpade om man har ett tak d\xe4r solpaneler sitter i m\xe5nga olika lutningar och v\xe4derstreck, alternativt om vissa av panelerna \xe4r utsatta f\xf6r skugga relativt ofta. "),Object(o.b)("p",null,"I \xf6vriga fall \xe4r det en smaksak. V\xe4rdes\xe4tter du att kunna \xf6vervaka produktionen i varje panel och vill f\xe5 ut n\xe5gon eller n\xe5gra procent extra elproduktion under anl\xe4ggningens livsl\xe4ngd? D\xe5 kan optimerare vara l\xf6sningen. Vill du \xe5 andra sidan ha ett mindre komplext system till en s\xe5 l\xe5g investeringskostnad som m\xf6jligt? Ja, d\xe5 \xe4r nog en vanlig str\xe4ngv\xe4xelriktare alternativet f\xf6r dig."),Object(o.b)("p",null,"F\xf6r mer l\xe4sning om hur optimerare fungerar, hur en vanlig anl\xe4ggning hanterar skugga, och vad som \xe4r bra att t\xe4nka p\xe5 n\xe4r man v\xe4ljer l\xf6sning, finns ",Object(o.b)("a",Object(a.a)({parentName:"p"},{href:"/blogg/optimerare-till-solcellsanlaggningen-vi-reder-ut-vad-som-ar-bra-att-tanka-pa"}),"en l\xe4ngre genomg\xe5ng h\xe4r"),"."))}g.isMDXComponent=!0}},[["smcd",1,0]]]);