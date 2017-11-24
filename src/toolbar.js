import $ from 'jquery';

import editor from './editor';
import { getNormalPreviewWidth } from './util';
import layout from './layout';
import NotyPopup from './noty_popups'

const getSampleText = (event) => {
	let text = editor.getSelection()
	if (text.trim() === '') {
		text = $(event.currentTarget).data('sample')
	}
	return text
}

const promptForValue = (key, action) => {
	$(document).on('opened', '#' + key + '-modal', () => {
		$('#' + key + '-code').focus()
	})
	$('#' + key + '-code').keyup((e) => {
		if (e.which === 13) { // press enter to confirm
			$('#' + key + '-confirm').click()
		}
	})
	$(document).on('confirmation', '#' + key + '-modal', () => {
		const value = $('#' + key + '-code').val().trim()
		if (value.length > 0) {
			action(value)
			$('#' + key + '-code').val('')
		}
	})
}

const loadFile = (value) => {

	if (value && value.length > 0) {
		if(!value.startsWith('saved/')) 
			value = `saved/${value}`;

		$.get(value, (data) => {
			editor.setValue(data)
			window.fileName = `${value}`; // save the filename
			NotyPopup.success(`<strong>Successfully Opened File!</strong><br/> (${value})`);
		}).fail(() => {
			
			NotyPopup.error(`<strong>Failed!</strong><br/> File(${value}) does not exist`);
		});
	} else {
		NotyPopup.warning(`<strong>Uh-Oh</strong><br/> Filename not specified`);
	}
};

const registerToolBarEvents = () => {
	// h1 - h6 heading
	$('.heading-icon').click((event) => {
		const level = $(event.currentTarget).data('level')
		const cursor = editor.getCursor()
		editor.setCursor(cursor.line, 0)
		editor.replaceSelection('#'.repeat(level) + ' ')
		editor.focus()
	})

	// styling icons
	$('.styling-icon').click((event) => {
		const modifier = $(event.currentTarget).data('modifier')
		if (!editor.somethingSelected()) {
			const word = editor.findWordAt(editor.getCursor())
			editor.setSelection(word.anchor, word.head)
		}
		editor.replaceSelection(modifier + editor.getSelection() + modifier)
		editor.focus()
	})

	// <hr/>
	$('#horizontal-rule').click(() => {
		const cursor = editor.getCursor()
		if (cursor.ch === 0) { // cursor is at line start
			editor.replaceSelection('\n---\n\n')
		} else {
			editor.setCursor({ line: cursor.line }) // navigate to end of line
			editor.replaceSelection('\n\n---\n\n')
		}
		editor.focus()
	})

	// list icons
	$('.list-icon').click((event) => {
		const prefix = $(event.currentTarget).data('prefix')
		const selection = editor.listSelections()[0]
		const minLine = Math.min(selection.head.line, selection.anchor.line)
		const maxLine = Math.max(selection.head.line, selection.anchor.line)
		for (let i = minLine; i <= maxLine; i++) {
			editor.setCursor(i, 0)
			editor.replaceSelection(prefix)
		}
		editor.focus()
	})

	$('#link-icon').click((event) => {
		let text = getSampleText(event)
		const url = $(event.currentTarget).data('sample-url')
		editor.replaceSelection(`[${text}](${url})`)
		editor.focus()
	})

	$('#image-icon').click((event) => {
		let text = getSampleText(event)
		const url = $(event.currentTarget).data('sample-url')
		editor.replaceSelection(`![${text}](${url})`)
		editor.focus()
	})

	$('#code-icon').click(() => {
		editor.replaceSelection(`\n\`\`\`\n${editor.getSelection()}\n\`\`\`\n`)
		editor.focus()
	})

	$('#table-icon').click((event) => {
		const sample = $(event.currentTarget).data('sample')
		const cursor = editor.getCursor()
		if (cursor.ch === 0) { // cursor is at line start
			editor.replaceSelection(`\n${sample}\n\n`)
		} else {
			editor.setCursor({ line: cursor.line }) // navigate to line end
			editor.replaceSelection(`\n\n${sample}\n`)
		}
		editor.focus()
	})
	
	/*
	
	$('#new-file-icon').click((event) => {
		$.get(`saved/template.md`, (data) => {
			editor.setValue(data)
			window.fileName = `saved/template.md`; // save the filename
			editor.focus();
			NotyPopup.success(`New File created based on template.md.<br/><br/>Please don't forget to use Save Document As (<i class="fa fa-files-o"></i>) to specify a new file name`);
		}).fail(() => {
			NotyPopup.error(`<strong>Failed to create a New File!</strong>`);
		})
	})
	
	*/
	
	$('#reload-file-icon').click((event) => {
		editor.setValue('Reloading File....Please Wait');
		loadFile(window.fileName);
	})
	
	$('#save-file-icon').click((event) => {
		$.post( 
			"file.php",
			JSON.stringify({
				'filename' : window.fileName,
				'contents' : editor.getValue()
			}),
			( data ) => {
				//console.log( data ); // John
				NotyPopup.success(`Successfully saved file (${window.fileName})`);
				// Trigger the event.
				//triggerEvent(document, 'data-refresh-event', {});
				document.dispatchEvent(new Event('data-refresh-event'));
			},
			"json"
		).fail(() => {
			NotyPopup.error(`<strong>Failed to save File!</strong>`);
		});
	})

	// emoji icon
	promptForValue('emoji', (value) => {
		if (/^:.+:$/.test(value)) {
			value = /^:(.+):$/.exec(value)[1]
		}
		editor.replaceSelection(`:${value}:`)
	})

	// Font Awesome icon
	promptForValue('fa', (value) => {
		if (value.substring(0, 3) === 'fa-') {
			value = value.substring(3)
		}
		editor.replaceSelection(`:fa-${value}:`)
	})
	
	// file-new icon
	promptForValue('file-new', (value) => {
		//editor.replaceSelection(`### Trying to save file ${value}:`)
		editor.setValue('Creating new File based on the default template... Please Wait!!!' );
		
		if(!value.startsWith('saved/')) 
			value = `saved/${value}`;
		
		$.get(`template.md`, (data) => {
			editor.setValue(data)
			window.fileName = value; // save the filename
			editor.focus();
			NotyPopup.success(`New File created based on template.md.`);
		}).fail(() => {
			NotyPopup.error(`<strong>Failed to create a New File!</strong>`);
		});
	});
	
	// file-save icon
	promptForValue('file-save', (value) => {
		//editor.replaceSelection(`### Trying to save file ${value}:`)
		
		if(!value.startsWith('saved/')) 
			value = `saved/${value}`;
		
		$.post(
			"file.php",
			JSON.stringify({
				'filename' : `${value}`,
				'contents' : editor.getValue()
			}),
			( data ) => {
				//console.log( data ); // John
				window.fileName = `${value}`; // save the filename
				NotyPopup.success(`<strong>Successfully saved file : ${value}</strong>`);
				// Trigger the event.
				//triggerEvent(document, 'data-refresh-event', {});
				document.dispatchEvent(new Event('data-refresh-event'));
			}, 
			"json"
		).fail(( jqXHR, textStatus, errorThrown) => {
			//console.log('Error thrown:', jqXHR, textStatus, errorThrown);
			NotyPopup.error(`<strong>Failed to save file : ${value}</strong>`);
		});
	})
	
	// file-open icon
	promptForValue('file-open', (value) => {
		//editor.replaceSelection(`### Trying to save file ${value}:`)
		//editor.save()
		
		if(!value.startsWith('saved/')) 
			value = `saved/${value}`;
		
		$.get(`${value}`, (data) => {
			editor.setValue(data)
			window.fileName = `${value}`; // save the filename
			NotyPopup.success(`<strong>Successfully Opened File!</strong><br/> (${value})`);
		}).fail(() => {
			
			NotyPopup.error(`<strong>Failed!</strong><br/> File(${value}) does not exist`);
		});
	})

	$('#math-icon').click((event) => {
		let text = getSampleText(event)
		editor.replaceSelection(`\n\`\`\`katex\n${text}\n\`\`\`\n`)
		editor.focus()
	})

	$('.mermaid-icon').click((event) => {
		let text = getSampleText(event)
		editor.replaceSelection(`\n\`\`\`mermaid\n${text}\n\`\`\`\n`)
		editor.focus()
	})

	$('#toggle-toolbar').click(() => {
		layout.toggle('north')
	})

	$('#toggle-editor').click(() => {
		if (layout.panes.center.outerWidth() < 8) { // editor is hidden
			layout.sizePane('east', getNormalPreviewWidth())
		} else {
			layout.sizePane('east', '100%')
		}
	})

	$('#toggle-preview').click(() => {
		if (layout.panes.east.outerWidth() < 8) { // preview is hidden
			layout.sizePane('east', getNormalPreviewWidth())
		} else {
			layout.sizePane('east', 1)
		}
	})
	
	/*
	$('.file-item').click((event) => {
		var fileToLoad = $(event.currentTarget).data('file-name');
		editor.setValue(`Opening File (${fileToLoad}).... Please Wait`);
		loadFile(fileToLoad);
	});
	*/
	
	$(document).on('click', '.file-item', (event) => {
		var fileToLoad = $(event.currentTarget).data('file-name');
		editor.setValue(`Opening File (${fileToLoad}).... Please Wait`);
		loadFile(fileToLoad);
	});
}

export { registerToolBarEvents }
