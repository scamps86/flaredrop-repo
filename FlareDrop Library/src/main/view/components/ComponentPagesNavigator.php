<?php

/**
 * Component that allows to navigate between pages
 *
 * The component is an UL list and the class name is: <b>componentPagesNavigator</b> and each page has the class <b>componentPagesNavigatorPage</b>,
 * each arrow has the class <b>componentPagesNavigatorArrow</b>, each glue has the class <b>componentPagesNavigatorGlue</b>.
 * The selected option have the class <b>componentPagesNavigatorPageSelected</b>
 * The component sets and gets the current page by the URL <b>page</b> parameter
 */
class ComponentPagesNavigator extends ComponentBase
{
    private $_glue = '';

    /**
     * Initialize the component.
     *
     * @param int $totalPages The total number of pages
     * @param string $id The component's id (not mandatory)
     * @param int $pagesToShow The number of pages to show (5 by default). For example, if we want to show 5 pages, the result will be:  < 12 - 13 - 14 - 15 - 16 >
     * @param string $glue The glue between pages. '|' by default
     * @param string $parameter The parameter to be used to save the current page to the URL. "page" by default
     *
     */
    function componentPagesNavigator($totalPages, $id = '', $pagesToShow = 5, $glue = '|', $parameter = 'page')
    {
        // Define the component's container
        $this->_defineComponentContainer('ul', 'componentPagesNavigator', $id);

        // Set the glue
        $this->_glue = $glue;

        // Get the page
        $page = UtilsHttp::getEncodedParam($parameter);
        $page = $page == '' ? 0 : $page;

        // Calculate the first page to show
        $firstPage = $page - floor($pagesToShow / 2);
        $firstPage = $firstPage < 0 ? 0 : $firstPage;
        $firstPage = $firstPage > $totalPages ? $totalPages : $firstPage;

        // Calculate the last page to show
        $lastPage = $firstPage + $pagesToShow;
        $lastPage = $lastPage > $totalPages ? $totalPages : $lastPage;

        // If the difference is less than the pages to show, means that we are on the last pages
        if ($lastPage - $firstPage < $pagesToShow) {
            $firstPage = $lastPage - $pagesToShow > 0 ? $lastPage - $pagesToShow : $firstPage;
        }

        // Calculate the pages to show
        $pagesToShow = $lastPage - $firstPage;

        // Generate the containing HTML
        if ($pagesToShow > 1) {
            // Get the current params
            $paramsCurrent = UtilsHttp::getEncodedParamsArray();

            // Show << only if the pages to show are less than the total pages and first is not displayed
            if ($pagesToShow < $totalPages && $firstPage > 0) {
                // Generate the first page html
                $paramsCurrent[$parameter] = 0;
                $this->_htmlContent .= '<li class="componentPagesNavigatorArrow"><a href="';
                $this->_htmlContent .= UtilsHttp::getSectionUrl(WebConstants::getSectionName(), $paramsCurrent, UtilsHttp::getDummy());
                $this->_htmlContent .= '">&#60;&#60;</a></li>';
            }

            // Show the previous page option only if the current page is not the first
            if ($page > 0) {
                $paramsCurrent[$parameter] = $page - 1;
                $this->_htmlContent .= '<li class="componentPagesNavigatorArrow"><a href="';
                $this->_htmlContent .= UtilsHttp::getSectionUrl(WebConstants::getSectionName(), $paramsCurrent, UtilsHttp::getDummy());
                $this->_htmlContent .= '">&#60;</a></li>';
            }

            // Loop the pages to show
            for ($i = 0; $i < $pagesToShow; $i++) {
                $pageIndex = $firstPage + $i;
                $paramsCurrent[$parameter] = $pageIndex;
                $this->_htmlContent .= '<li class="componentPagesNavigatorPage' . ($page == $pageIndex ? ' componentPagesNavigatorPageSelected' : '') . '"><a href="';
                $this->_htmlContent .= UtilsHttp::getSectionUrl(WebConstants::getSectionName(), $paramsCurrent, UtilsHttp::getDummy());
                $this->_htmlContent .= '">' . ($pageIndex + 1) . '</a></li>';

                if ($i < $pagesToShow - 1) {
                    $this->_htmlContent .= '<li class="componentPagesNavigatorGlue"><p>' . $this->_glue . '</p></li>';
                }
            }

            // Show the next page option only if the current page is not the last
            if ($page < $totalPages - 1) {
                $paramsCurrent[$parameter] = $page + 1;
                $this->_htmlContent .= '<li class="componentPagesNavigatorArrow"><a href="';
                $this->_htmlContent .= UtilsHttp::getSectionUrl(WebConstants::getSectionName(), $paramsCurrent, UtilsHttp::getDummy());
                $this->_htmlContent .= '">&#62;</a></li>';
            }

            // Show >> only if the pages to show are less than the total pages and last page is not displayed
            if ($pagesToShow < $totalPages && $lastPage < $totalPages) {
                // Generate the first page html
                $paramsCurrent[$parameter] = $totalPages - 1;
                $this->_htmlContent .= '<li class="componentPagesNavigatorArrow"><a href="';
                $this->_htmlContent .= UtilsHttp::getSectionUrl(WebConstants::getSectionName(), $paramsCurrent, UtilsHttp::getDummy());
                $this->_htmlContent .= '">&#62;&#62;</a></li>';
            }
        }
    }

}