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
let CompareTableHelper = {
  cellToColor: (header) => {
    switch (header) {
      case 'Standard Not Met':
        return 'danger'
      case 'Near Standard':
        return 'warning'
      case 'Standard Met':
      case 'Standard Exceeded':
        return 'success'
      default:
        return ''
    }
  }
}
$(function () {
  let dataTable
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
      let i = 2
      let checkboxes = filterBox.find('input:checkbox'),
          numBoxes   = checkboxes.length
      columns = Array.matrix(numBoxes - 1, 1, {})
      columns[0] = {name: 'fname', visible: true}
      columns[1] = {name: 'lname', visible: true}
      checkboxes.each(function () {
        columns[i++] = {
          name   : $(this).val(),
          visible: $(this).prop('checked')
        }
      })
    }
    dataTable = table.show().DataTable({
      serverSide : true,
      processing : true,
      responsive : true,
      columns    : columns,
      rowCallback: (r, d) => compareTableColors(r, d, type),
      ajax       : {
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

  function compareTableColors (row, data, type) {
    if (type === 'psat') {
      $('td:eq(4)', row).addClass('success')
    } else {
      $(row).find('td').each(function () {
        let index = $(this).index(),
            th    = $(dataTable.column(index).header())

        $('td:eq(' + index + ')', row).addClass(CompareTableHelper.cellToColor($(this).text()))

      })
    }
  }
})