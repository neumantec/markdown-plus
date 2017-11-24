import $ from 'jquery'

import editor from './editor'
import { getPreviewWidth, lazyChange } from './util'

const layout = $('#mdp-container').layout({ // create 3-panels layout
  resizerDblClickToggle: false,
  resizable: false,
  slidable: false,
  north: {
    togglerLength_open: 128,
    togglerLength_closed: 128,
    size: 25,
    togglerTip_open: 'Hide toolbar',
    togglerTip_closed: 'Show toolbar',
    onopen: () => {
      editor.focus()
    },
    onclose: () => {
      editor.focus()
    }
  },
  east: {
    resizable: true,
    togglerLength_open: 0,
    size: getPreviewWidth(),
    onresize: () => {
      lazyChange()
      editor.focus()
      $('article#preview').css('padding-bottom', ($('.ui-layout-east').height() - parseInt($('article#preview').css('line-height'), 10) + 1) + 'px') // scroll past end
    }
  },
  
  west: {
    togglerLength_open: 128,
    togglerLength_closed: 128,
    size: 100,
    togglerTip_open: 'Hide File List',
    togglerTip_closed: 'Show File List'
  }
})

export default layout
