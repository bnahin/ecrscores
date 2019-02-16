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
 * Hover over icon (Info icon)
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
  if ($('.compare-table').length) {
    let dataTable
    $('.compare-select').val(null).trigger('change')
    //TODO Custom Column Visibility
    $('.static-table').DataTable({
      drawCallback: () => {

      }
    })
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
  }
})

/** View Charts **/
let ViewTableHelper = {
  showPeekPopover: (td, grade, content) => {
    td.popover({
      content  : content,
      title    : 'Result in SBAC ' + grade,
      container: 'body',
      placement: 'right',
      html     : true,
      trigger  : 'click'
    }).popover('show')
  }
}
$(function () {
  if ($('.static-table').length) {
    function loadSparklines (destroy) {
      if (destroy) {
        $('.sparklines-box').sparkline('destroy')
        $('.sparklines-line').sparkline('destroy')
        return loadSparklines(false)
      }
      $('.sparklines-box').sparkline('html', {type: 'box'})
      $('.sparklines-pie').sparkline('html', {
        type               : 'pie',
        sliceColors        : ['gray', 'red', 'yellow', 'lightgreen', 'darkgreen'],
        tooltipFormat      : '{{offset:offset}} ({{percent.1}}%)',
        tooltipValueLookups: {
          'offset': {
            0: 'No Score',
            1: 'Standard Not Met',
            2: 'Near Standard',
            3: 'Standard Met',
            4: 'Standard Exceeded'
          }
        },
      })
    }

    loadSparklines(false)
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      loadSparklines(true)
    })

    //Popover Ajax
    $('.static-table').find('td').on('click', function (e) {
      let td = $(this)
      let grade  = $(this).data('grade'),
          ssid   = $(this).data('ssid'),
          fields = $(this).data('fields').split(',')
      // ViewTableHelper.showPeekPopover(td, grade, 'Loading...')
      $.ajax({
        url    : '/ajax/getCellData',
        data   : {
          grade : grade,
          ssid  : ssid,
          fields: fields
        },
        type   : 'POST',
        success: result => {
          ViewTableHelper.showPeekPopover(td, grade, result)
        },
        error  : () => ViewTableHelper.showPeekPopover(td, grade, '<em>Error - No Data</em>')
      })
    })
  }
})

/** Homepage Charts **/
$(function () {
  if ($('.static-table').length) return null
  /** PSAT Averages **/
  new Chart(document.getElementById('psat-averages'), {
    type   : 'bar',
    data   : {
      labels  : ['2016-2017', '2017-2018'],
      datasets: [{
        label          : 'Math',
        data           : [600, 710],
        fill           : true,
        backgroundColor: ['rgba(255, 99, 132)', 'rgba(255, 99, 132)'],
        borderWidth    : 1
      }, {
        label          : 'Reading/Writing',
        data           : [700, 450],
        fill           : true,
        backgroundColor: ['rgba(153, 102, 255)', 'rgba(153, 102, 255)'],
        borderWidth    : 1
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks  : {beginAtZero: true},
          stacked: true
        }],
        xAxes: [{
          stacked: true
        }]
      }
    }
  })

  /** SBAC Averages **/
  new Chart(document.getElementById('sbac-averages'), {
    type   : 'bar',
    data   : {
      labels  : ['2016-2017', '2017-2018'],
      datasets: [{
        label          : 'ELA Scale',
        data           : [2500, 3500],
        fill           : true,
        backgroundColor: ['rgba(255, 99, 132)', 'rgba(255, 99, 132)'],
        borderWidth    : 1
      }, {
        label          : 'Math Scale',
        data           : [2600, 2500],
        fill           : true,
        backgroundColor: ['rgba(153, 102, 255)', 'rgba(153, 102, 255)'],
        borderWidth    : 1
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks  : {beginAtZero: true},
          stacked: false
        }],
        xAxes: [{
          stacked: false
        }]
      }
    }
  })

  let levelColors = ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(50, 245, 115)', 'rgb(6, 121, 44)'],
      data        = []

  /** SBAC Math Levels **/
  $.get('/ajax/getLevels/math', function (response) {
    data = []
    for (let d in response)
      if (response.hasOwnProperty(d))
        data.push(response[d]['total'])
    new Chart(document.getElementById('math-levels'), {
      type: 'pie',
      data: {
        labels  : ['Standard Not Met', 'Near Standard', 'Meets Standard', 'Exceeds Standard'],
        datasets: [{
          label          : 'My First Dataset',
          data           : data,
          backgroundColor: levelColors
        }]
      }
    })
  })

  /** SBAC ELA Levels **/
  $.get('/ajax/getLevels/ela', function (response) {
    data = []
    for (let d in response)
      if (response.hasOwnProperty(d))
        data.push(response[d]['total'])
    new Chart(document.getElementById('ela-levels'), {
      type: 'pie',
      data: {
        labels  : ['Standard Not Met', 'Near Standard', 'Meets Standard', 'Exceeds Standard'],
        datasets: [{
          label          : 'My First Dataset',
          data           : data,
          backgroundColor: levelColors
        }]
      }
    })
  })

})