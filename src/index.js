import $ from 'jquery'
import Noty from 'noty'

window.$ = window.jQuery = $


// load sample text and get anchor links correct
$(() => {
  const editor = require('./editor').default
  require('./init')
  require('./preferences')
  $.get('saved/template.md', (data) => {
    editor.setValue(data)
    window.fileName = 'template.md';
    setTimeout(() => {
      // a little gap to top
      window.addEventListener('hashchange', () => {
        $('.ui-layout-east').scrollTop($('.ui-layout-east').scrollTop() - 6)
      })

      // scroll to hash element
      if (window.location.hash.length > 0) {
        $('.ui-layout-east').scrollTop($(window.location.hash).offset().top - 30)
      }
    }, 3000)
  })
  require('./index.css')
})
