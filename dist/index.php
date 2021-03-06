<?php ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Markdown Plus Based Requirements Manager</title>
    <link href="icon.png" rel="shortcut icon" type="image/png"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.layout/1.4.3/layout-default.css">
    <link rel="stylesheet" href="index.bundle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remodal/1.1.1/remodal.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remodal/1.1.1/remodal-default-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.2/noty.css" />
  </head>
  <body>
    <div id="mdp-container" style="height: 99%;">
      <div class="ui-layout-north">
        <div id="toolbar" class="noselect">
          <i title="New Document" class="fa fa-file" id='new-file-icon' data-remodal-target="file-new-modal"></i>
          <i title="Open Document" class="fa fa-folder-open" data-remodal-target="file-open-modal"></i>
          <i title="Save Document" class="fa fa-save" id='save-file-icon' data-modifier="**"></i>
          <i title="Save Document As" class="fa fa-files-o" data-remodal-target="file-save-modal"></i>
          <i title="Reload Document" class="fa fa-repeat" id='reload-file-icon'></i>
          <i class="dividor">|</i>
          <i title="Bold" class="fa fa-bold styling-icon" data-modifier="**"></i>
          <i title="Italic" class="fa fa-italic styling-icon" data-modifier="*"></i>
          <i title="Strikethrough" class="fa fa-strikethrough styling-icon" data-modifier="~~"></i>
          <i title="Underline" class="fa fa-underline styling-icon" data-modifier="++"></i>
          <i title="Mark" class="fa fa-pencil styling-icon" data-modifier="=="></i>
          <i class="dividor">|</i>
          <i title="Heading 1" class="fa heading-icon" data-level="1">h1</i>
          <i title="Heading 2" class="fa heading-icon" data-level="2">h2</i>
          <i title="Heading 3" class="fa heading-icon" data-level="3">h3</i>
          <i title="Heading 4" class="fa heading-icon" data-level="4">h4</i>
          <i title="Heading 5" class="fa heading-icon" data-level="5">h5</i>
          <i title="Heading 6" class="fa heading-icon" data-level="6">h6</i>
          <i class="dividor">|</i>
          <i title="Horizontal rule" id="horizontal-rule" class="fa fa-minus"></i>
          <i title="Quote" class="fa fa-quote-left list-icon" data-prefix="> "></i>
          <i title="Unordered list" class="fa fa-list-ul list-icon" data-prefix="- "></i>
          <i title="Ordered list" class="fa fa-list-ol list-icon" data-prefix="1. "></i>
          <i title="Incomplete task list" class="fa fa-square-o list-icon" data-prefix="- [ ] "></i>
          <i title="Complete task list" class="fa fa-check-square-o list-icon" data-prefix="- [x] "></i>
          <i class="dividor">|</i>
          <i title="Link" class="fa fa-link" id="link-icon" data-sample="link" data-sample-url="http://mdp.tylingsoft.com/"></i>
          <i title="Image" class="fa fa-image" id="image-icon" data-sample="image" data-sample-url="http://mdp.tylingsoft.com/icon.png"></i>
          <i title="Code" class="fa fa-code" id="code-icon"></i>
          <i title="Table" class="fa fa-table" id="table-icon" data-sample="header 1 | header 2
---|---
row 1 col 1 | row 1 col 2
row 2 col 1 | row 2 col 2"></i>
          <i class="dividor">|</i>
          <i title="Emoji" class="fa fa-smile-o" data-remodal-target="emoji-modal"></i>
          <i title="Font awesome" class="fa fa-flag-o" data-remodal-target="fa-modal"></i>
          <i class="dividor">|</i>
          <i title="Mathematical formula" class="fa fa-superscript" id="math-icon" data-sample="E = mc^2"></i>
          <i title="Flowchart" class="fa fa-long-arrow-right mermaid-icon" data-sample="graph LR
A-->B"></i>
          <i title="Sequence diagram" class="fa fa-exchange mermaid-icon" data-sample="sequenceDiagram
A->>B: How are you?
B->>A: Great!"></i>
          <i title="Gantt diagram" class="fa fa-sliders mermaid-icon" data-sample="gantt
dateFormat YYYY-MM-DD
section S1
T1: 2014-01-01, 9d
section S2
T2: 2014-01-11, 9d
section S3
T3: 2014-01-02, 9d"></i>
          <i class="dividor">|</i>
          <i title="Hide toolbar" class="fa fa-long-arrow-up" id="toggle-toolbar"></i>
          <i title="Toggle editor" class="fa fa-long-arrow-left" id="toggle-editor"></i>
          <i title="Toggle preview" class="fa fa-long-arrow-right" id="toggle-preview"></i>
          <i class="dividor">|</i>
          <i title="Preferences" class="fa fa-cog" data-remodal-target="preferences-modal"></i>
          <i title="Help" class="fa fa-question-circle" data-remodal-target="help-modal"></i>
          <i title="About" class="fa fa-info-circle" data-remodal-target="about-modal"></i>
        </div>
      </div>
      <div class="ui-layout-center">
        <textarea id="editor"></textarea> <!-- editor -->
        
        <div class="remodal" id="file-open-modal" data-remodal-id="file-open-modal"> <!-- file-open modal -->
          <h2>Please enter an existing file name:</h2>
          <p>Filename that you previously saved and want to load back ...</p>
          
          <p><input class="form-control" id="file-open-code" placeholder="Enter Filename.md"/></p>
          <br/><a data-remodal-action="cancel" class="remodal-cancel">Cancel</a>
          <a data-remodal-action="confirm" class="remodal-confirm" id="file-open-confirm">OK</a>
        </div>
        
        <div class="remodal" id="file-new-modal" data-remodal-id="file-new-modal"> <!-- file-save modal -->
          <h2>Please enter a file name:</h2>
          <p>Something U can remember and load back later ...</p>
          
          <p><input class="form-control" id="file-new-code" placeholder="Enter Filename.md"/></p>
          <br/><a data-remodal-action="cancel" class="remodal-cancel">Cancel</a>
          <a data-remodal-action="confirm" class="remodal-confirm" id="file-new-confirm">OK</a>
        </div>
        
        <div class="remodal" id="file-save-modal" data-remodal-id="file-save-modal"> <!-- file-save modal -->
          <h2>Please enter a file name:</h2>
          <p>Something U can remember and load back later ...</p>
          
          <p><input class="form-control" id="file-save-code" placeholder="Enter Filename.md"/></p>
          <br/><a data-remodal-action="cancel" class="remodal-cancel">Cancel</a>
          <a data-remodal-action="confirm" class="remodal-confirm" id="file-save-confirm">OK</a>
        </div>
        
        <div class="remodal" id="emoji-modal" data-remodal-id="emoji-modal"> <!-- emoji modal -->
          <h2>Please enter an emoji code:</h2>
          <p>Examples: "smile", "whale", "santa", "panda_face", "dog", "truck" ...</p>
          <p>For a complete list, please check <a href="http://www.emoji-cheat-sheet.com/" target="_blank">Emoji Cheat Sheet</a>.</p>
          <p><input class="form-control" id="emoji-code" placeholder="smile"/></p>
          <br/><a data-remodal-action="cancel" class="remodal-cancel">Cancel</a>
          <a data-remodal-action="confirm" class="remodal-confirm" id="emoji-confirm">OK</a>
        </div>
        <div class="remodal" id="fa-modal" data-remodal-id="fa-modal"> <!-- Font Awesome modal -->
          <h2>Please enter a Font Awesome code:</h2>
          <p>Examples: "cloud", "flag", "car", "truck", "heart", "dollar" ...</p>
          <p>For a complete list, please check <a href="http://fontawesome.io/icons/" target="_blank">Font Awesome Icons</a>.</p>
          <p><input class="form-control" id="fa-code" placeholder="heart"/></p>
          <br/><a data-remodal-action="cancel" class="remodal-cancel">Cancel</a>
          <a data-remodal-action="confirm" class="remodal-confirm" id="fa-confirm">OK</a>
        </div>
        <div class="remodal" id="preferences-modal" data-remodal-id="preferences-modal" data-remodal-options="closeOnEscape: false, closeOnCancel: false, closeOnOutsideClick: false"> <!-- Preferences modal -->
          <img src="icon.png" width="64"/>
          <h2>Markdown Plus Preferences</h2>
          <p>Show toolbar: <select id="show-toolbar">
            <option value="yes">Yes</option>
            <option value="no">No</option>
          </select></p>
          <p>Editor : Preview <select id="editor-versus-preview">
            <option value="100%">0 : 1</option>
            <option value="66.6%">1 : 2</option>
            <option value="50%">1 : 1</option>
            <option value="33.3%">2 : 1</option>
            <option value="1">1 : 0</option>
          </select></p>
          <p>Editor theme: <select id="editor-theme">
            <option value="3024-day">3024-day</option>
            <option value="3024-night">3024-night</option>
            <option value="abcdef">abcdef</option>
            <option value="ambiance-mobile">ambiance-mobile</option>
            <option value="ambiance">ambiance</option>
            <option value="base16-dark">base16-dark</option>
            <option value="base16-light">base16-light</option>
            <option value="bespin">bespin</option>
            <option value="blackboard">blackboard</option>
            <option value="cobalt">cobalt</option>
            <option value="colorforth">colorforth</option>
            <option value="default">default</option>
            <option value="dracula">dracula</option>
            <option value="duotone-dark">duotone-dark</option>
            <option value="duotone-light">duotone-light</option>
            <option value="eclipse">eclipse</option>
            <option value="elegant">elegant</option>
            <option value="erlang-dark">erlang-dark</option>
            <option value="hopscotch">hopscotch</option>
            <option value="icecoder">icecoder</option>
            <option value="isotope">isotope</option>
            <option value="lesser-dark">lesser-dark</option>
            <option value="liquibyte">liquibyte</option>
            <option value="material">material</option>
            <option value="mbo">mbo</option>
            <option value="mdn-like">mdn-like</option>
            <option value="midnight">midnight</option>
            <option value="monokai">monokai</option>
            <option value="neat">neat</option>
            <option value="neo">neo</option>
            <option value="night">night</option>
            <option value="panda-syntax">panda-syntax</option>
            <option value="paraiso-dark">paraiso-dark</option>
            <option value="paraiso-light">paraiso-light</option>
            <option value="pastel-on-dark">pastel-on-dark</option>
            <option value="railscasts">railscasts</option>
            <option value="rubyblue">rubyblue</option>
            <option value="seti">seti</option>
            <option value="solarized">solarized</option>
            <option value="the-matrix">the-matrix</option>
            <option value="tomorrow-night-bright">tomorrow-night-bright</option>
            <option value="tomorrow-night-eighties">tomorrow-night-eighties</option>
            <option value="ttcn">ttcn</option>
            <option value="twilight">twilight</option>
            <option value="vibrant-ink">vibrant-ink</option>
            <option value="xq-dark">xq-dark</option>
            <option value="xq-light">xq-light</option>
            <option value="yeti">yeti</option>
            <option value="zenburn">zenburn</option>
          </select></p>
          <p>Editor font size: <select id="editor-font-size">
            <option value="8">8px</option><option value="9">9px</option><option value="10">10px</option><option value="11">11px</option>
            <option value="12">12px</option><option value="13">13px</option><option value="14">14px</option><option value="15">15px</option>
            <option value="16">16px</option><option value="17">17px</option><option value="18">18px</option><option value="20">20px</option>
            <option value="24">24px</option><option value="32">32px</option><option value="48">48px</option><option value="64">64px</option>
          </select></p>
          <p>Key binding: <select id="key-binding">
            <option value="default">Default</option>
            <option value="sublime">Sublime</option>
            <option value="vim">Vim</option>
            <option value="emacs">Emacs</option>
          </select></p>
          <p>Gantt diagram axis format: <input id="gantt-axis-format" placeholder="%Y-%m-%d"/>
            <br/><a href="https://github.com/mbostock/d3/wiki/Time-Formatting" target="_blank">Time formatting reference</a></p>
          <p>Custom CSS files: <textarea id="custom-css-files" wrap="off" placeholder="https://cdn.example.com/file.css" title="Multiple files should be separated by line breaks"></textarea>
            <br/><span class="hint">(You need to restart the editor to apply the CSS files)</span>
            <br/><a href="https://github.com/tylingsoft/markdown-plus-themes" target="_blank">Markdown Plus themes</a></p>
          <p>Custom JS files: <textarea id="custom-js-files" wrap="off" placeholder="https://cdn.example.com/file.js" title="Multiple files should be separated by line breaks"></textarea>
            <br/><span class="hint">(You need to restart the editor to apply the JS files)</span>
            <br/><a href="https://github.com/tylingsoft/markdown-plus-plugins" target="_blank">Markdown Plus plugins</a></p>
          <br/><a data-remodal-action="confirm" class="remodal-confirm">OK</a>
        </div>
        <div class="remodal" data-remodal-id="help-modal"> <!-- help modal -->
          <img src="icon.png" width="64"/>
          <h2>Markdown Plus help</h2>
          <p><a href="http://mdp.tylingsoft.com/" target="_blank">Online Sample</a></p>
          <p><a href="https://guides.github.com/features/mastering-markdown/" target="_blank">Markdown Basics</a></p>
          <p><a href="https://help.github.com/articles/github-flavored-markdown/" target="_blank">GitHub Flavored Markdown</a></p>
          <p>If none of the above solves your problem, please <a target="_blank" href="http://tylingsoft.com/contact/">contact us</a>.</p>
          <br/><a data-remodal-action="confirm" class="remodal-confirm">OK</a>
        </div>
        <div class="remodal" data-remodal-id="about-modal"> <!-- about modal -->
          <img src="icon.png" width="64"/>
          <h2>Markdown Plus</h2> Version 2.x
          <p>Markdown editor with extra features.</p>
          <p>Copyright © 2015 - 2017 <a href="http://tylingsoft.com" target="_blank">Tylingsoft</a>.</p>
          <p>Home page: <a href="http://tylingsoft.com/markdown-plus/" target="_blank">http://tylingsoft.com/markdown-plus/</a>.</p>
          <br/><a data-remodal-action="confirm" class="remodal-confirm">OK</a>
        </div>
      </div>
      <div class="ui-layout-east">
        <article class="markdown-body" id="preview"></article>
      </div>
      <div class="ui-layout-west" id="file-list">
        <div class='file-header'>List of Files</div>
        <div class="ui-layout-content">
          <div class="noselect">
              <file-entry v-for="file in files" :file="file" :c-file="currFile"></file-entry>
          <?php /* ?>
            <?php 
              $directory = './saved';
              $scanned_directory = array_diff(scandir($directory), array('..', '.'));
              foreach ($scanned_directory as $file) { 
            ?>
              <div class="p-all-2">
                <div class='file-item' data-file-name="<?=$file?>">
                  <i title="<?=$file?>" class="fa fa-file"></i>
                  <div class="file-name"><?=$file?></div>
                </div>
              </div>
            <?php } ?>
            <?php */ ?>
          </div>
        </div>
      </div>
    </div>
    <script src="index.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/remodal/1.1.1/remodal.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.layout/1.4.3/jquery.layout.min.js"></script>
    <script src="https://cdn.jsdelivr.net/mojs/latest/mo.min.js"></script> <!-- Used by Noty for animation -->
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script>
        Vue.component('file-entry', {
           props: ['file', 'cFile'],
           template: `
               <div class="p-all-2">
                <div class='file-item' :data-file-name="file" :class="{selected : (file == cFile)}">
                    <i :title="file" class="fa fa-file"></i>
                    <div class="file-name">{{ file }}</div>
                </div>
              </div>
           `
        });
        
        $(() => {
            var filesListApp = new Vue({
                el : '#file-list',
                data: function(){
                    return {
                        files       : [],//['a.md', 'b.md', 'c.md'];
                        endpoint    : 'file.php',
                        currFile    : null
                    };
                },
    			
    			created: function () {
    			    // `this` points to the vm instance
    			    this.fetch();
    			},
    			
    			methods: {
    		        fetch: function() {
    		            $.get(this.endpoint, (data) => {
    		                this.files = data;
    		            })
    		            .fail(() => {
                			NotyPopup.error(`<strong>Failed to load files list!</strong>`);
                		});
    		        },

    		        setActiveFile: function() {
    		            var f = window.fileName; 
    		            if(f.indexOf('/') !== -1)
    		                f = f.split('/')[1];
    		                
    		            this.currFile = f;
    		        }
    		    }
            });
            
            // Add an event listener.
            document.addEventListener('data-refresh-event', function (e) {
                filesListApp.fetch();
            }, false);
            
            document.addEventListener('file-editing-event', function (e) {
                filesListApp.setActiveFile();
            }, false);
        })
        
    </script>
  </body>
</html>
