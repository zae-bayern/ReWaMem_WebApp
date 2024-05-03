(function(){
  if (typeof document.addEventListener != "function") {
    if (document.attachEvent && / MSIE 8/.test(navigator.userAgent)) {
      document.addEventListener = function(a, b, c) {
        return document.attachEvent("on"+a, b);
      };
      document.removeEventListener = function(a, b, c) {
        return document.detachEvent("on"+a, b);
      };
    } else
      return;
  }
  var selects = [];
  var e = document.getElementById('dateselect');
  if (e) {
    var s = e.getElementsByTagName('SELECT');
    for (var i = 0; i < s.length; i++)
      selects[selects.length] = s[i];
  }
  e = document.getElementById('filterselect');
  if (e) {
    if (!selects)
      selects = [];
    s = e.getElementsByTagName('SELECT');
    for (i = 0; i < s.length; i++)
      selects[selects.length] = s[i];
  }
  e = document.getElementById('factoryselect');
  if (e) {
    if (!selects)
      selects = [];
    s = e.getElementsByTagName('SELECT');
    for (i = 0; i < s.length; i++)
      selects[selects.length] = s[i];
  }
  e = document.getElementById('orgselect');
  if (e) {
    if (!selects)
      selects = [];
    s = e.getElementsByTagName('SELECT');
    for (i = 0; i < s.length; i++)
      selects[selects.length] = s[i];
  }
  e = document.getElementById('filterselectright');
  if (e) {
    if (!selects)
      selects = [];
    s = e.getElementsByTagName('SELECT');
    for (i = 0; i < s.length; i++)
      selects[selects.length] = s[i];
  }
  if (!selects || !selects.length)
    return;
  
  var listener, listenerouter;
  
  function clicked() {
    if (listenerouter) {
      closesel(listenerouter);
      listenerouter = null;
    }
    document.removeEventListener('click', clicked);
    listener = null;
  }
  
  function closesel(outer) {
    if (listener) {
      document.removeEventListener('click', clicked)
      listener = null;
    }
    outer.childNodes[2].style.display = 'none';
  }
  
  function optionclick() {
    if (this.sel.selectedIndex == this.ind) {
      closesel(this.parentNode.parentNode);
      return;
    }
    this.sel.selectedIndex = this.ind;
    var seltext = this.parentNode.parentNode.childNodes[1];
    seltext.className = this.ind ? "seltext hassel" : "seltext";
    while (seltext.childNodes.length)
      seltext.removeChild(seltext.childNodes[0]);
    seltext.appendChild(document.createTextNode(this.opttext));
    var options = this.parentNode.childNodes;
    for (var i = 0; i < options.length; i++) {
      options[i].className = options[i] == this ?
        'option selected' : 'option';
    }
    closesel(this.parentNode.parentNode);
    if (this.sel.onchange)
      this.sel.onchange();
  }
  
  function selclick() {
    var e = this.parentNode.childNodes[0];
    setTimeout(function() {
      e.nextSibling.nextSibling.style.display = '';
      listenerouter = e.parentNode;
      listener = document.addEventListener('click', clicked);
    }, 100);
  }
  
  function selchanged(sel) {
    var seltext = sel.outer.childNodes[1];
    while (seltext.childNodes.length)
      seltext.removeChild(seltext.childNodes[0]);
    var choose = sel.outer.childNodes[2];
    var options = choose.childNodes;
    var ind = 0;
    if (sel.selectedIndex > 0)
      ind = sel.selectedIndex;
    if (/(^| )clearable( |$)/.test("" + sel.className))
      ind++;
    for (var i = 1; i <= options.length; i++) {
      var opt = options[i-1];
      opt.className = i == ind ? 'option selected' : 'option';
      if (i == ind)
        seltext.appendChild(
          document.createTextNode(opt.opttext));
    }
    if (/(^| )clearable( |$)/.test("" + sel.className))
      ind--;
    if (!ind)
      seltext.className = "seltext";
    else
      seltext.className = "seltext hassel";
    if (sel.outer.oldonchange)
      sel.outer.oldonchange();
  }
  
  function updatechoose(sel, choose) {
    while (choose.childNodes.length > 0)
      choose.removeChild(choose.childNodes[0]);
    if (/(^| )clearable( |$)/.test("" + sel.className) /* &&
      sel.selectedIndex > 0 */) {
      var clearopt = document.createElement('DIV');
      clearopt.className = 'option';
      clearopt.val = '';
      clearopt.ind = 0;
      clearopt.opttext = '';
      clearopt.sel = sel;
      clearopt.onclick = optionclick;
      clearopt.appendChild(document.createTextNode('keine Auswahl'));
      choose.appendChild(clearopt);
    }
    for (var i = 1; i < sel.options.length; i++) {
      var val = sel.options[i].value;
      var text = sel.options[i].text;
      var option = document.createElement('DIV');
      option.className = 'option';
      option.val = val;
      option.ind = i;
      option.opttext = text;
      option.sel = sel;
      option.appendChild(document.createTextNode(text));
      option.onclick = optionclick;
      choose.appendChild(option);
    }
  }
  
  function newselect(sel) {
    var outer = document.createElement('DIV');
    var show = document.createElement('DIV');
    var seltext = document.createElement('DIV');
    var choose = document.createElement('DIV');
    outer.className = 'sel';
    show.className = 'show';
    show.onclick = selclick;
    var showtext = sel.options[0].text;
    show.appendChild(document.createTextNode(showtext));
    seltext.className = sel.selectedIndex > 0 ?
      'seltext hassel' : 'seltext';
    var opttext = sel.selectedIndex < 0 ? sel.options[0].text :
      sel.options[sel.selectedIndex].text;
    seltext.appendChild(document.createTextNode(opttext));
    seltext.onclick = selclick;
    choose.className = 'choose';
    choose.sel = sel;
    choose.style.display = 'none';
    outer.appendChild(show);
    outer.appendChild(seltext);
    updatechoose(sel, choose);
    outer.appendChild(choose);
    sel.outer = outer;
    sel.updatechoose = function() {
      updatechoose(sel, choose);
    };
    outer.oldonchange = sel.onchange;
    sel.onchange = (function(e) {
      return function() { selchanged(e); };
    })(sel);
    return outer;
  }
  
  for (var i = 0; i < selects.length; i++) {
    selects[i].style.display = 'none';
    var n = newselect(selects[i]);
    selects[i].parentNode.insertBefore(n, selects[i]);
  }
  
  })();
  (function(){
  if (typeof oekobench_jsdates == "undefined")
    return;
  var jsdates = oekobench_jsdates;
  var months = oekobench_months;
  var e = document.getElementById('dateselect');
  if (!e)
    return;
  var selects = e.getElementsByTagName('SELECT');
  var oldonchange = [];
  
  function updateselects() {
    var ysel = selects[0];
    var msel = selects[1];
    var dsel = selects[2];
  
    if (ysel.options.length < 2)
      return;
    if (ysel.selectedIndex < 1)
      ysel.selectedIndex = 1;
    var year = parseInt(ysel.options[ysel.selectedIndex].value);
    for (var y = 0; y < jsdates.length; y++)
      if (jsdates[y][0] == year)
        break;
    var mval = msel.selectedIndex > 0 ?
      parseInt(msel.options[msel.selectedIndex].value) : 0;
    msel.selectedIndex = 0;
    while (msel.options.length > 1)
      msel.options[msel.options.length-1] = null;
    for (var i = 0; i < jsdates[y][1].length; i++) {
      var m = jsdates[y][1][i][0];
      msel.options[msel.options.length] = new Option(months[m-1], m);
      if (mval == m)
        msel.selectedIndex = i+1;
    }
    if (msel.updatechoose)
      msel.updatechoose();
    if (oldonchange[1])
      oldonchange[1]();
    if (dsel.updatechoose)
      dsel.updatechoose();
    if (oldonchange[2])
      oldonchange[2]();
  }
  
  for (var i = 0; i < selects.length; i++) {
    oldonchange[i] = selects[i].onchange;
    selects[i].onchange = updateselects;
  }
  
  updateselects();
  })();