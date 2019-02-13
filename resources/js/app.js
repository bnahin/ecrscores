/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap')

/** Static Table Popover **/
/**
 * If in 8th grade tab, view category info for 11th grade
 * If in 11th grade tab, view category info for 8th grade
 * Hover over icon
 */

/** Compare Tab **/
$(function () {
  $('.compare-select').val(null).trigger('change')
  //TODO Custom Column Visibility
  $('.static-table').DataTable()
  $('.select2-course').select2({
    templateSelection: course => course.element.dataset.label
  }).on('select2:select', function (e) {
    let data = e.params.data,
        col  = data.element.dataset.col,
        exam = $('#examselect-' + col).find(':selected').val()
    if (exam.length) loadData(col)
    else destroyTable(col)
  })
  $('.select2-exam').select2()
    .on('select2:select', function (e) {
      let data   = e.params.data,
          col    = data.element.dataset.col,
          course = $('#courseselect-' + col).find(':selected').val()
      if (course.length) loadData(col)
      else destroyTable(col)
    })

  function loadData (col) {
    destroyTable(col)
    console.log('Loading data to ' + col)

    //Get selected values
    let exam   = $('#examselect-' + col).find(':selected').val(),
        course = $('#courseselect-' + col).find(':selected').val()
    if (!exam.length || !course.length) return null

    //Get type
    let type      = exam.split('-')[0],
        table     = $('#' + type + '-compare-' + col),
        filterBox = $('#filter-box-' + col),
        columns   = []
    console.log(type) //SBAC|PSAT|...

    //Show and Initialize data table, with AJAX
    if (type === 'psat') {
      columns = [
        {name: 'fname'},
        {name: 'lname'},
        {name: 'readwrite'},
        {name: 'math'},
        {name: 'total'}
      ]
      filterBox.hide()
    } else {
      filterBox.show()
      let i = 0
      let checkboxes = filterBox.find('input:checked'),
          numBoxes   = checkboxes.length,
          columns    = Array.matrix(numBoxes - 1, 1, {})
      checkboxes.each(function () {
        columns[i++] = {name: $(this).val()}
      })
      console.log(columns)
    }

    table.show().DataTable({
      serverSide: true,
      processing: true,
      responsive: true,
      columns   : columns,
      ajax      : {
        type: 'POST',
        url : '/ajax/getTableData',
        data: {
          course: course,
          exam  : exam
        }
      }
    })

  }

  function destroyTable (col) {
    let table     = $('.compare-table[id$="compare-' + col + '"]'),
        filterBox = $('#filter-box-' + col)
    filterBox.hide()
    table.DataTable().destroy()
    table.hide()
  }
})