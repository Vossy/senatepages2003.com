/*
KOIVI TTW WYSIWYG Editor Copyright (C) 2004 Justin Koivisto
Version 2.0
Last Modified: 12/9/2004

    This library is free software; you can redistribute it and/or modify it
    under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation; either version 2.1 of the License, or (at
    your option) any later version.

    This library is distributed in the hope that it will be useful, but
    WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
    or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public
    License for more details.

    You should have received a copy of the GNU Lesser General Public License
    along with this library; if not, write to the Free Software Foundation,
    Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA 

    Full license agreement notice can be found in the LICENSE file contained
    within this distribution package.

    Justin Koivisto
    justin.koivisto@gmail.com
    http://www.koivi.com
*/

/*
    Display
    Configures and displays the editor according to values passed
*/
function Display(hidden_field,path,fwidth,fheight,content){
    hidden_name=hidden_field;   // use this to define the name of the field that contains the HTML on submission
    viewMode=1;                 // by default, set to design view
    wysiwyg_path=path;          // defines the path to use for the editor files (pallete, images, etc)
    frame_width=fwidth;         // sets the width of the editor on screen
    frame_height=fheight;       // sets the height of the editor on screen
    if( (browser.isWin32 && (browser.isGecko || browser.isIE5up))
            || ((browser.isMac || browser.isLinux || browser.isUnix) && browser.isGecko)) {
        DisplayEditor();
        LoadExistingContent(content);
        document.getElementById('wysiwyg_content').contentWindow.document.designMode='On';
        document.getElementById('wysiwyg_content').contentWindow.document.open();
        document.getElementById('wysiwyg_content').contentWindow.document.write(content);
        document.getElementById('wysiwyg_content').contentWindow.document.close();
    }else{
        ta_rows=Math.round(fheight/15);
        ta_cols=Math.round(fwidth/8);
        DisplayTextArea();
        LoadExistingContent(content);
    }
}

/*
    DoTextFormat
    Performs specified commands on the selected text inside the IFRAME element
*/
function DoTextFormat(command, optn){
    if((command=='forecolor') || (command=='hilitecolor')){
        if(browser.isIE5up){
            SetColorIE(command);
        }else{
            parent.command=command;
            layerid=command+'0';
            buttonElement=document.getElementById(command);
            document.getElementById(layerid).style.left=GetOffsetLeft(buttonElement) + 'px';
            document.getElementById(layerid).style.top=(GetOffsetTop(buttonElement) + buttonElement.offsetHeight) + 'px';
            if(document.getElementById(layerid).style.visibility=='hidden')
                document.getElementById(layerid).style.visibility='visible';
            else{
                document.getElementById(layerid).style.visibility='hidden';
            }
    
            //get current selected range
            var sel=document.getElementById('wysiwyg_content').contentWindow.document.selection;
            if(sel!=null){
                rng=sel.createRange();
            }
        }
    }else if(command=='createlink'){
        var szURL=prompt('Enter a URL:', '');
        if(document.getElementById('wysiwyg_content').contentWindow.document.queryCommandEnabled(command)){
            document.getElementById('wysiwyg_content').contentWindow.document.execCommand('CreateLink',false,szURL);
            return true;
        }else return false;
    }else{
        if(document.getElementById('wysiwyg_content').contentWindow.document.queryCommandEnabled(command)){
              document.getElementById('wysiwyg_content').contentWindow.document.execCommand(command, false, optn);
              return true;
          }else return false;
    }
    document.getElementById('wysiwyg_content').contentWindow.focus();
}

/*
    SetColor
    Used to set the text or highlight color of the selected text in Gecko engine browsers
*/
function SetColor(color){
    elem=command+'0';
    document.getElementById('wysiwyg_content').contentWindow.focus();
    if(document.getElementById('wysiwyg_content').contentWindow.document.queryCommandEnabled(command)){
        document.getElementById('wysiwyg_content').contentWindow.document.execCommand(command, false, color);
    }else return false;
    document.getElementById('wysiwyg_content').contentWindow.focus();
    document.getElementById(elem).style.visibility='hidden';
    return true;
}

/*
    SetColorIE
    Used to set the text or highlight color of the selected text in MSIE - uses a different method for pop-up pallete window
*/
function SetColorIE(command,args){
    elem=command+'0';
    buttonElement=document.getElementById(elem);
    var color = showModalDialog(wysiwyg_path+"/palette-ie.html", 0, 'resizable: no; help: no; status: no; scroll: no;');
    if(command=='hilitecolor') command='backcolor';
    if(document.getElementById('wysiwyg_content').contentWindow.document.queryCommandEnabled(command)){
        document.getElementById('wysiwyg_content').contentWindow.document.execCommand(command, false, color);
    }else return false;
    document.getElementById('wysiwyg_content').contentWindow.focus();
    return true;
}

/*
    GetOffsetTop
    Used to define position of pop-up pallete window in Gecko browsers
*/
function GetOffsetTop(elm){
    var mOffsetTop=elm.offsetTop;
    var mOffsetParent=elm.offsetParent;
    while(mOffsetParent){
        mOffsetTop += mOffsetParent.offsetTop;
        mOffsetParent=mOffsetParent.offsetParent;
    }
    return mOffsetTop;
}

/*
    GetOffsetLeft
    Used to define position of pop-up pallete window in Gecko browsers
*/
function GetOffsetLeft(elm){
    var mOffsetLeft=elm.offsetLeft;
    var mOffsetParent=elm.offsetParent;
    while(mOffsetParent){
        mOffsetLeft += mOffsetParent.offsetLeft;
        mOffsetParent=mOffsetParent.offsetParent;
    }
    return mOffsetLeft;
}

/*
    ProcessInfo
    Used in the onSubmit event for the form. Puts the HTML content into a hidden form field for the submission
*/
function ProcessInfo(){
    var htmlCode=document.getElementById('wysiwyg_content').contentWindow.document.body.innerHTML;
    document.getElementById('wysiwyg_hidden').value=htmlCode;
    return true;
}

/*
    LoadExistingContent
    Puts the passed content into the editor or textarea
*/
function LoadExistingContent(content){
    document.getElementById('wysiwyg_hidden').value=content;
}

/*
    ToggleMode
    Toggles between design view and source view in the IFRAME element    
*/
function ToggleMode(){
    if(browser.isIE5up){
        if(viewMode == 2){
            document.getElementById('wysiwyg_content').contentWindow.document.body.innerHTML = document.getElementById('wysiwyg_content').contentWindow.document.body.innerText;
            document.getElementById('wysiwyg_content').contentWindow.document.body.style.fontFamily = '';
            document.getElementById('wysiwyg_content').contentWindow.document.body.style.fontSize = '';
            document.getElementById('wysiwyg_content').contentWindow.focus();
            viewMode = 1; // WYSIWYG
        }else{
            document.getElementById('wysiwyg_content').contentWindow.document.body.innerText = document.getElementById('wysiwyg_content').contentWindow.document.body.innerHTML;
            document.getElementById('wysiwyg_content').contentWindow.document.body.style.fontFamily = 'monospace';
            document.getElementById('wysiwyg_content').contentWindow.document.body.style.fontSize = '10pt';
            document.getElementById('wysiwyg_content').contentWindow.focus();
            viewMode = 2; // Code
        }
    }else{
        if(viewMode == 2){
            var html = document.getElementById('wysiwyg_content').contentWindow.document.body.ownerDocument.createRange();
            html.selectNodeContents(document.getElementById('wysiwyg_content').contentWindow.document.body);
            document.getElementById('wysiwyg_content').contentWindow.document.body.innerHTML = html.toString();
            document.getElementById('wysiwyg_content').contentWindow.document.body.style.fontFamily = '';
            document.getElementById('wysiwyg_content').contentWindow.document.body.style.fontSize = '';
            document.getElementById('toolbars').style.visibility='visible';
            viewMode = 1; // WYSIWYG
        }else{
            var html = document.createTextNode(document.getElementById('wysiwyg_content').contentWindow.document.body.innerHTML);
            document.getElementById('wysiwyg_content').contentWindow.document.body.innerHTML = '';
            document.getElementById('wysiwyg_content').contentWindow.document.body.appendChild(html);
            document.getElementById('wysiwyg_content').contentWindow.document.body.style.fontFamily = 'monospace';
            document.getElementById('wysiwyg_content').contentWindow.document.body.style.fontSize = '10pt';
            document.getElementById('toolbars').style.visibility='hidden';
            viewMode = 2; // Code
        }
    }
}

/*
    CheckSpelling
    Uses the ieSpell Active X control for MSIE browsers.
*/
function CheckSpelling(){
    try{
        var tmpis = new ActiveXObject('ieSpell.ieSpellExtension');
        tmpis.CheckAllLinkedDocuments(document);
    }
    catch(exception){
        if(exception.number==-2146827859){
            if(confirm('ieSpell not detected.  Click Ok to go to download page.'))
                window.open('http://www.iespell.com/download.php','Download');
        }
        else
            alert('Error Loading ieSpell: Exception ' + exception.number);
    }
}

/*
    InsertTable
    Used with Gecko browsers for inserting a table into the IFRAME content window
*/
function InsertTable(border,padding,spacing){
    if(browser.isIE5up){
        colstext = prompt('Enter the number of columns per row.');
        rowstext = prompt('Enter the number of rows to create.');
        rows = parseInt(rowstext);
        cols = parseInt(colstext);

        document.getElementById('wysiwyg_content').contentWindow.focus();
        var cursor = document.getElementById('wysiwyg_content').document.selection.createRange();
        if(rows<1) rows=1;
        if(cols<1) cols=1;

        var ieTable = '<table border="'+border+'" cellpadding="'+padding+'" cellspacing="'+spacing+'">';
        while(rows>0){
            rows--;
            var rowCols = cols;
            ieTable = ieTable + '<tr>';
            while(parseInt(rowCols)>0){
                rowCols--;
                ieTable=ieTable+'<td>&nbsp;</td>';
            }
            ieTable = ieTable + '</tr>';
        }
        ieTable = ieTable + '</table>';
        cursor.pasteHTML(ieTable);
        document.getElementById('wysiwyg_content').contentWindow.focus();
    }else{
        // Gecko browsers
        e = document.getElementById('wysiwyg_content');
        colstext = prompt('Enter the number of columns per row.');
        rowstext = prompt('Enter the number of rows to create.');
        rows = parseInt(rowstext);
        cols = parseInt(colstext);
        if((rows > 0) && (cols > 0)){
            table = e.contentWindow.document.createElement('table');
            table.setAttribute('border', border);
            table.setAttribute('cellpadding', padding);
            table.setAttribute('cellspacing', spacing);
            tbody = e.contentWindow.document.createElement('tbody');
            for (var i=0; i < rows; i++) {
                tr =e.contentWindow.document.createElement('tr');
                for (var j=0; j < cols; j++) {
                    td =e.contentWindow.document.createElement('td');
                    br =e.contentWindow.document.createElement('br');
                    td.appendChild(br);
                    tr.appendChild(td);
                }
                tbody.appendChild(tr);
            }
            table.appendChild(tbody);
            insertNodeAtSelection(e.contentWindow, table);
        }
    }
    return true;
}

/*
    insertNodeAtSelection
    Used in the Gecko browser InsertTable function
*/
function insertNodeAtSelection(win, insertNode){
    var sel = win.getSelection();           // get current selection
    var range = sel.getRangeAt(0);          // get the first range of the selection (there's almost always only one range)
    sel.removeAllRanges();                  // deselect everything
    range.deleteContents();                 // remove content of current selection from document
    var container = range.startContainer;   // get location of current selection
    var pos = range.startOffset;
    range=document.createRange();           // make a new range for the new selection

    if (container.nodeType==3 && insertNode.nodeType==3) {
        // if we insert text in a textnode, do optimized insertion
        container.insertData(pos, insertNode.nodeValue);

        // put cursor after inserted text
        range.setEnd(container, pos+insertNode.length);
        range.setStart(container, pos+insertNode.length);
    }else{
        var afterNode;
        if (container.nodeType==3) {
          // when inserting into a textnode we create 2 new textnodes and put the insertNode in between
          var textNode = container;
          container = textNode.parentNode;
          var text = textNode.nodeValue;

          var textBefore = text.substr(0,pos);  // text before the split
          var textAfter = text.substr(pos);     // text after the split

          var beforeNode = document.createTextNode(textBefore);
          var afterNode = document.createTextNode(textAfter);

          // insert the 3 new nodes before the old one
          container.insertBefore(afterNode, textNode);
          container.insertBefore(insertNode, afterNode);
          container.insertBefore(beforeNode, insertNode);

          // remove the old node
          container.removeChild(textNode);
        }else{
          // else simply insert the node
          afterNode = container.childNodes[pos];
          container.insertBefore(insertNode, afterNode);
        }
    }
}

/*
    DisplayEditor
    Used to display the actual wysiwyg editor
*/
function DisplayEditor(){
    document.write('   <input type="hidden" name="'+hidden_name+'" id="wysiwyg_hidden">');
    document.write('   <table cellpadding="5" cellspacing="0" border="2" bgcolor="#dfdfdf">');
    document.write('    <tr>');
    document.write('     <td>');
    document.write('      <table width="100%" border="0" cellspacing="0" cellpadding="0">');
    document.write('       <tr>');
    document.write('        <td valign="top" colspan="2">');
    document.write('         <div id="toolbars">');
    document.write('          <select onChange="DoTextFormat(\'fontname\',this.options[this.selectedIndex].value)">');
    document.write('           <option value="">- Font -</option>');
    document.write('           <option value="cursive">Cursive</option>');
    document.write('           <option value="fantasy">Fantasy</option>');
    document.write('           <option value="sans-serif">Sans Serif</option>');
    document.write('           <option value="serif">Serif</option>');
    document.write('           <option value="monospace">Typewriter</option>');
    document.write('          </select>'); /*
    document.write('          <select onChange="DoTextFormat(\'fontSize\',this.options[this.selectedIndex].value)">');
    document.write('           <option value="">- Size -</option>');
    document.write('           <option value="-2">X Small</option>');
    document.write('           <option value="-1">Small</option>');
    document.write('           <option value="+0">Medium</option>');
    document.write('           <option value="+1">Large</option>');
    document.write('           <option value="+2">X Large</option>');
    document.write('          </select>');
    document.write('          <select onChange="DoTextFormat(\'formatblock\',this.options[this.selectedIndex].value)">');
    document.write('           <option value="<p>">Normal</option>');
    document.write('           <option value="<h1>">Heading 1</option>');
    document.write('           <option value="<h2>">Heading 2</option>');
    document.write('           <option value="<h3>">Heading 3</option>');
    document.write('           <option value="<h4>">Heading 4</option>');
    document.write('           <option value="<h5>">Heading 5</option>');
    document.write('           <option value="<h6>">Heading 6</option>');
    document.write('           <option value="<address>">Address</option>');
    document.write('          </select>'); */
    document.write('           <img alt="Font Color" title="Font Color" class="butClass" src="'+wysiwyg_path+'/images/forecol.png" onClick="DoTextFormat(\'forecolor\',\'\')" id="forecolor">');
    document.write('           <img alt="Background Color" title="Background Color" class="butClass" src="'+wysiwyg_path+'/images/bgcol.png" onClick="DoTextFormat(\'hilitecolor\',\'\')" id="hilitecolor">');
    document.write('         <img alt="|" src="'+wysiwyg_path+'/images/separator.png">');
    document.write('          <img alt="Bold" title="Bold" class="butClass" src="'+wysiwyg_path+'/images/bold.png" onClick="DoTextFormat(\'bold\',\'\')">');
    document.write('          <img alt="Italic" title="Italic" class="butClass" src="'+wysiwyg_path+'/images/italic.png" onClick="DoTextFormat(\'italic\',\'\')">');
    document.write('          <img alt="Underline" title="Underline" class="butClass" src="'+wysiwyg_path+'/images/underline.png" onClick="DoTextFormat(\'underline\',\'\')">');
    document.write('         <br>');
    document.write('          <img alt="Left" title="Left" class="butClass" src="'+wysiwyg_path+'/images/left.png" onClick="DoTextFormat(\'justifyleft\',\'\')">');
    document.write('          <img alt="Center" title="Center" class="butClass" src="'+wysiwyg_path+'/images/center.png" onClick="DoTextFormat(\'justifycenter\',\'\')">');
    document.write('          <img alt="Right" title="Right" class="butClass" src="'+wysiwyg_path+'/images/right.png" onClick="DoTextFormat(\'justifyright\',\'\')">');
//          <img alt="Full" title="Full" class="butClass" src="'+wysiwyg_path+'/images/full.png" onClick="DoTextFormat('justifyfull',\'\')">
    document.write('         <img alt="|" src="'+wysiwyg_path+'/images/separator.png">');
    document.write('          <img alt="Superscript" title="Superscript" class="butClass" src="'+wysiwyg_path+'/images/sup.png" onClick="DoTextFormat(\'superscript\',\'\')">');
    document.write('          <img alt="Subscript" title="Subscript" class="butClass" src="'+wysiwyg_path+'/images/sub.png" onClick="DoTextFormat(\'subscript\',\'\')">');
    document.write('         <img alt="|" src="'+wysiwyg_path+'/images/separator.png">');
    document.write('          <img alt="Hyperlink" title="Hyperlink" class="butClass" src="'+wysiwyg_path+'/images/link.png" onClick="DoTextFormat(\'createlink\',\'\')">');
    document.write('          <img alt="Remove Link" title="Remove Link" class="butClass" src="'+wysiwyg_path+'/images/unlink.png" onClick="DoTextFormat(\'unlink\',\'\')">');
    document.write('          <img alt="Ordered List" title="Ordered List" class="butClass" src="'+wysiwyg_path+'/images/ordlist.png"  onClick="DoTextFormat(\'insertorderedlist\',\'\')">');
    document.write('          <img alt="Bulleted List" title="Bulleted List" class="butClass" src="'+wysiwyg_path+'/images/bullist.png" onClick="DoTextFormat(\'insertunorderedlist\',\'\')">');
    document.write('          <img alt="Indent" title="Indent" src="'+wysiwyg_path+'/images/indent.png" class=butClass onClick="DoTextFormat(\'indent\',\'\')">');
    document.write('          <img alt="Outdent" title="Outdent" src="'+wysiwyg_path+'/images/outdent.png" class=butClass onClick="DoTextFormat(\'outdent\',\'\')">');
    document.write('         <img alt="|" src="'+wysiwyg_path+'/images/separator.png">');
    document.write('          <img alt="Horizontal Rule" title="Horizontal Rule" class="butClass" src="'+wysiwyg_path+'/images/rule.png" onClick="DoTextFormat(\'inserthorizontalrule\',\'\')">');
    document.write('          <img alt="Insert Table" title="Insert Table" class="butClass" src="'+wysiwyg_path+'/images/table.png" onClick="InsertTable(1,3,0)">');
//         <br>
//          <img alt="Remove Formatting" title="Remove Formatting" class="butClass" src="'+wysiwyg_path+'/images/unformat.png" onClick="DoTextFormat('removeformat',\'\')">
//         <img alt="|" src="'+wysiwyg_path+'/images/separator.png">
//          <img alt="Undo" title="Undo" class="butClass" src="'+wysiwyg_path+'/images/undo.png" onClick="DoTextFormat('undo',\'\')">
//          <img alt="Redo" title="Redo" class="butClass" src="'+wysiwyg_path+'/images/redo.png" onClick="DoTextFormat('redo',\'\')">
//         <img alt="|" src="'+wysiwyg_path+'/images/separator.png">
//          <img alt="Cut" title="Cut" class="butClass" src="'+wysiwyg_path+'/images/cut.png" onClick="DoTextFormat('cut',\'\')">
//          <img alt="Copy" title="Copy" class="butClass" src="'+wysiwyg_path+'/images/copy.png" onClick="DoTextFormat('copy',\'\')">
//          <img alt="Paste" title="Paste" class="butClass" src="'+wysiwyg_path+'/images/paste.png" onClick="DoTextFormat('paste',\'\')">
    document.write('         </div>');
    document.write('        </td>');
    document.write('       </tr>');
    document.write('      </table>');
    document.write('      <iframe id="wysiwyg_content" style="margin-left: 3px; background-color: white; color: black; width:'+frame_width+'px; height:'+frame_height+'px"></iframe>');
    if(browser.isIE5up){
        document.write('      <iframe width="175" height="125" id="forecolor0" src="'+wysiwyg_path+'/palette-ie.html" style="visibility:hidden; position: absolute; left: 0px; top: 0px;"></iframe>');
        document.write('      <iframe width="175" height="125" id="hilitecolor0" src="'+wysiwyg_path+'/palette-ie.html" style="visibility:hidden; position: absolute; left: 0px; top: 0px;"></iframe>');
    }else{
        document.write('      <iframe width="175" height="125" id="forecolor0" src="'+wysiwyg_path+'/palette.html" style="visibility:hidden; position: absolute; left: 0px; top: 0px;"></iframe>');
        document.write('      <iframe width="175" height="125" id="hilitecolor0" src="'+wysiwyg_path+'/palette.html" style="visibility:hidden; position: absolute; left: 0px; top: 0px;"></iframe>');
    }
    document.write('      <table width="'+frame_width+'" border="0" cellspacing="0" cellpadding="0" bgcolor="#dfdfdf">');
    document.write('       <tr>');
    document.write('        <td>');
    document.write('        </td>');
    document.write('        <td align="right">');
    if(browser.isIE5up)
        document.write('         <img alt="Spell Check" title="Spell Check" class="butClass" src="'+wysiwyg_path+'/images/spelling.png" onClick="CheckSpelling()">');
    document.write('         <img alt="Toggle Mode" title="Toggle Mode" class="butClass" src="'+wysiwyg_path+'/images/mode.png" onClick="ToggleMode()">');
    document.write('        </td>');
    document.write('       </tr>');
    document.write('      </table>');
    document.write('     </td>');
    document.write('    </tr>');
    document.write('   </table>');
    document.write('   <br>');
}

/*
    DisplayTextArea
    Displays a textarea input as well as a generic message to the user letting them know their browser does not support the programming
*/
function DisplayTextArea(){
    document.write('<p style="background-color: yellow; color: red; padding: 3px;"><b>WARNING:</b> Your browser does not support the WYSIWYG editor. The script you are posting to may expect HTML code.</p>');
    document.write('<textarea name="'+hidden_name+'" id="wysiwyg_hidden" rows="'+ta_rows+'" cols="'+ta_cols+'"></textarea><br>');
}
