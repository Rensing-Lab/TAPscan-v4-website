/**
 *  Copyright (C) 2017 Christian M. Zmasek
 *  Copyright (C) 2017 J. Craig Venter Institute
 *  All rights reserved
 *
 *  This library is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Lesser General Public
 *  License as published by the Free Software Foundation; either
 *  version 2.1 of the License, or (at your option) any later version.
 *
 *  This library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *  Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public
 *  License along with this library; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA
 *
 */

// v 1_02alpha
// 2017-06-21

// Developer documentation:
// https://docs.google.com/document/d/1COVe0iYbKtcBQxGTP4_zuimpk2FH9iusOVOgd5xCJ3A

// User documentation:
// https://docs.google.com/document/d/16PjoaNeNTWPUNVGcdYukP6Y1G35PFhq39OiIMmD03U8


if (!d3) {
    throw "no d3.js";
}

if (!forester) {
    throw "no forester.js";
}

if (!phyloXml) {
    throw "no phyloxml.js";
}
(function archaeopteryx() {

    "use strict";

    var VERSION = '1.02a';
    var WEBSITE = 'https://sites.google.com/site/cmzmasek/home/software/archaeopteryx-js';
    var NAME = 'Archaeopteryx.js';
    var PROG_NAME = 'progname';
    var PROGNAMELINK = 'prognamelink';

    var LIGHT_BLUE = '#2590FD';
    var WHITE = '#ffffff';

    var COLOR_FOR_ACTIVE_ELEMENTS = LIGHT_BLUE;

    var TRANSITION_DURATION_DEFAULT = 750;
    var ROOTOFFSET_DEFAULT = 180;
    var DISPLAY_WIDTH_DEFAULT = 800;
    var VIEWERHEIGHT_DEFAULT = 600;
    var CONTROLS_0_LEFT_DEFAULT = 20;
    var CONTROLS_0_TOP_DEFAULT = 20;
    var CONTROLS_1_WIDTH = 120;
    var CONTROLS_1_TOP_DEFAULT = 20;
    var CONTROLS_FONT_SIZE_DEFAULT = 9;
    var CONTROLS_FONT_COLOR_DEFAULT = '#505050';
    var CONTROLS_FONT_DEFAULTS = ['Arial', 'Helvetica', 'Tahoma', 'Geneva', 'Verdana', 'Sans-Serif'];
    var CONTROLS_BACKGROUND_COLOR_DEFAULT = '#e0e0e0';
    var DUPLICATION_COLOR = '#ff0000';
    var SPECIATION_COLOR = '#00ff00';
    var DUPLICATION_AND_SPECIATION_COLOR_COLOR = '#ffff00';
    var RECENTER_AFTER_COLLAPSE_DEFAULT = false;
    var BRANCH_LENGTH_DIGITS_DEFAULT = 4;
    var CONFIDENCE_VALUE_DIGITS_DEFAULT = 2;
    var ZOOM_INTERVAL = 200;
    var MOVE_INTERVAL = 150;
    var BUTTON_ZOOM_IN_FACTOR = 1.1;
    var BUTTON_ZOOM_OUT_FACTOR = 1 / BUTTON_ZOOM_IN_FACTOR;
    var BUTTON_ZOOM_IN_FACTOR_SLOW = 1.05;
    var BUTTON_ZOOM_OUT_FACTOR_SLOW = 1 / BUTTON_ZOOM_IN_FACTOR_SLOW;

    var NODE_TOOLTIP_TEXT_COLOR = WHITE;
    var NODE_TOOLTIP_TEXT_ACTIVE_COLOR = COLOR_FOR_ACTIVE_ELEMENTS;
    var NODE_TOOLTIP_BACKGROUND_COLOR = '#606060';

    var NODE_SIZE_MAX = 9;
    var NODE_SIZE_MIN = 1;
    var BRANCH_WIDTH_MAX = 9;
    var BRANCH_WIDTH_MIN = 0.5;
    var FONT_SIZE_MAX = 26;
    var FONT_SIZE_MIN = 2;
    var SLIDER_STEP = 0.5;

    var LABEL_SIZE_CALC_FACTOR = 0.5;
    var LABEL_SIZE_CALC_ADDITION = 40;

    var OVERLAY = 'overlay';

    var KEY_FOR_COLLAPSED_FEATURES_SPECIAL_LABEL = 'collapsed_spec_label';

    var CONTROLS_0 = 'controls0';
    var CONTROLS_1 = 'controls1';

    var PHYLOGRAM_BUTTON = 'phy_b';
    var PHYLOGRAM_ALIGNED_BUTTON = 'phya_b';
    var CLADOGRAM_BUTTON = 'cla_b';

    var PHYLOGRAM_CLADOGRAM_CONTROLGROUP = 'phy_cla_g';
    var DISPLAY_DATA_CONTROLGROUP = 'display_data_g';

    var NODE_NAME_CB = 'nn_cb';
    var TAXONOMY_CB = 'tax_cb';
    var SEQUENCE_CB = 'seq_cb';
    var CONFIDENCE_VALUES_CB = 'conf_cb';
    var BRANCH_LENGTH_VALUES_CB = 'bl_cb';
    var NODE_EVENTS_CB = 'nevts_cb';
    var BRANCH_EVENTS_CB = 'brevts_cb';
    var INTERNAL_LABEL_CB = 'intl_cb';
    var EXTERNAL_LABEL_CB = 'extl_cb';
    var INTERNAL_NODES_CB = 'intn_cb';
    var EXTERNAL_NODES_CB = 'extn_cb';
    var NODE_VIS_CB = 'nodevis_cb';
    var BRANCH_VIS_CB = 'branchvis_cb';
    var DYNAHIDE_CB = 'branchvis_cb';

    var ZOOM_IN_Y = 'zoomout_y';
    var ZOOM_OUT_Y = 'zoomin_y';
    var ZOOM_IN_X = 'zoomin_x';
    var ZOOM_OUT_X = 'zoomout_x';
    var ZOOM_TO_FIT = 'zoomtofit';

    var INTERNAL_FONT_SIZE_SLIDER = 'intfs_sl';
    var EXTERNAL_FONT_SIZE_SLIDER = 'entfs_sl';
    var BRANCH_DATA_FONT_SIZE_SLIDER = 'bdfs_sl';
    var BRANCH_WIDTH_SLIDER = 'bw_sl';
    var NODE_SIZE_SLIDER = 'ns_sl';

    var ORDER_BUTTON = 'ord_b';
    var RETURN_TO_SUPERTREE_BUTTON = 'ret_b';
    var UNCOLLAPSE_ALL_BUTTON = 'unc_b';

    var SEARCH_FIELD_0 = 'sf0';
    var SEARCH_FIELD_1 = 'sf1';
    var RESET_SEARCH_A_BTN = 'reset_s_a';
    var RESET_SEARCH_B_BTN = 'reset_s_b';
    var RESET_SEARCH_A_BTN_TOOLTIP = 'reset (remove) search result A';
    var RESET_SEARCH_B_BTN_TOOLTIP = 'reset (remove) search result B';

    var DECR_DEPTH_COLLAPSE_LEVEL = 'decr_dcl';
    var INCR_DEPTH_COLLAPSE_LEVEL = 'incr_dcl';
    var DECR_BL_COLLAPSE_LEVEL = 'decr_blcl';
    var INCR_BL_COLLAPSE_LEVEL = 'incr_blcl';
    var DEPTH_COLLAPSE_LABEL = 'depth_col_label';
    var BL_COLLAPSE_LABEL = 'bl_col_label';

    var NODE_DATA = 'node_data_dialog';

    var COLLAPSE_BY_FEATURE_SELECT = 'coll_by_feat_sel';
    var SPECIES_FEATURE = 'Species';
    var OFF_FEATURE = 'off';

    var NODE_SHAPE_SELECT_MENU = 'nshapes_menu';
    var NODE_FILL_COLOR_SELECT_MENU = 'nfcolors_menu';
    var NODE_BORDER_COLOR_SELECT_MENU = 'nbcolors_menu';
    var NODE_SIZE_SELECT_MENU = 'nsizes_menu';
    var LABEL_COLOR_SELECT_MENU = 'lcs_menu';

    var SEARCH_OPTIONS_GROUP = 'search_opts_g';
    var SEARCH_OPTIONS_CASE_SENSITIVE_CB = 'so_cs_cb';
    var SEARCH_OPTIONS_COMPLETE_TERMS_ONLY_CB = 'so_cto_cb';
    var SEARCH_OPTIONS_REGEX_CB = 'so_regex_cb';
    var SEARCH_OPTIONS_NEGATE_RES_CB = 'so_neg_cb';

    var DOWNLOAD_BUTTON = 'dl_b';
    var EXPORT_FORMAT_SELECT = 'exp_f_sel';
    var PNG_EXPORT_FORMAT = 'PNG';
    var SVG_EXPORT_FORMAT = 'SVG';
    var PHYLOXML_EXPORT_FORMAT = 'phyloXML';
    var NH_EXPORT_FORMAT = 'Newick';
    var PDF_EXPORT_FORMAT = 'PDF';
    var NAME_FOR_NH_DOWNLOAD_DEFAULT = 'archaeopteryx-js.nh';
    var NAME_FOR_PHYLOXML_DOWNLOAD_DEFAULT = 'archaeopteryx-js.xml';
    var NAME_FOR_PNG_DOWNLOAD_DEFAULT = 'archaeopteryx-js.png';
    var NAME_FOR_SVG_DOWNLOAD_DEFAULT = 'archaeopteryx-js.svg';

    var BRANCH_EVENT_REF = 'aptx:branch_event';
    var BRANCH_EVENT_DATATYPE = 'xsd:string';
    var BRANCH_EVENT_APPLIES_TO = 'parent_branch';

    var NONE = 'none';
    var DEFAULT = 'default';
    var SAME_AS_FILL = 'sameasfill';

    var LEGEND_LABEL_COLOR = 'legendLabelColor';
    var LEGEND_NODE_FILL_COLOR = 'legendNodeFillColor';
    var LEGEND_NODE_BORDER_COLOR = 'legendNodeBorderColor';
    var LEGEND_NODE_SHAPE = 'legendNodeShape';
    var LEGEND_NODE_SIZE = 'legendNodeSize';

    var ORDINAL_SCALE = 'ordinal';
    var LINEAR_SCALE = 'linear';

    var HORIZONTAL = 'horizontal';
    var VERTICAL = 'vertical';

    var VISUALIZATIONS_LEGEND_XPOS_DEFAULT = 160;
    var VISUALIZATIONS_LEGEND_YPOS_DEFAULT = 30;
    var VISUALIZATIONS_LEGEND_ORIENTATION_DEFAULT = VERTICAL;

    var LEGENDS_SHOW_BTN = 'legends_show';
    var LEGENDS_HORIZ_VERT_BTN = 'legends_horizvert';
    var LEGENDS_MOVE_UP_BTN = 'legends_mup';
    var LEGENDS_MOVE_LEFT_BTN = 'legends_mleft';
    var LEGENDS_RESET_BTN = 'legends_rest';
    var LEGENDS_MOVE_RIGHT_BTN = 'legends_mright';
    var LEGENDS_MOVE_DOWN_BTN = 'legends_mdown';

    var COLOR_PICKER = 'col_pick';
    var COLOR_PICKER_CLICKED_ORIG_COLOR_BORDER_COLOR = '#000000';
    var COLOR_PICKER_BACKGROUND_BORDER_COLOR = '#808080';

    var COLOR_PICKER_LABEL = 'colorPickerLabel';

    var LEGEND = 'legend';
    var LEGEND_LABEL = 'legendLabel';
    var LEGEND_DESCRIPTION = 'legendDescription';

    var VK_ESC = 27;
    var VK_O = 79;
    var VK_R = 82;
    var VK_U = 85;
    var VK_P = 80;
    var VK_A = 65;
    var VK_S = 83;
    var VK_L = 76;
    var VK_C = 67;
    var VK_DELETE = 46;
    var VK_BACKSPACE = 8;
    var VK_HOME = 36;
    var VK_UP = 38;
    var VK_DOWN = 40;
    var VK_LEFT = 37;
    var VK_RIGHT = 39;
    var VK_PLUS = 187;
    var VK_MINUS = 189;
    var VK_PLUS_N = 107;
    var VK_MINUS_N = 109;
    var VK_PAGE_UP = 33;
    var VK_PAGE_DOWN = 34;

    var WARNING = 'ArchaeopteryxJS: WARNING';

    // "Instance variables"
    var _root = null;
    var _svgGroup = null;
    var _baseSvg = null;
    var _treeFn = null;
    var _superTreeRoots = [];
    var _treeData = null;
    var _options = null;
    var _settings = null;
    var _nodeVisualizations = null;
    var _maxLabelLength = 0;
    var _i = 0;
    var _zoomListener = null;
    var _yScale = null;
    var _translate = null;
    var _scale = null;
    var _foundNodes0 = new Set();
    var _foundNodes1 = new Set();
    var _foundSum = 0;
    var _totalSearchedWithData = 0;
    var _searchBox0Empty = true;
    var _searchBox1Empty = true;
    var _displayWidth = 0;
    var _displayHeight = 0;
    var _intervalId = 0;
    var _currentLabelColorVisualization = null;
    var _currentNodeShapeVisualization = null;
    var _currentNodeFillColorVisualization = null;
    var _currentNodeBorderColorVisualization = null;
    var _currentNodeSizeVisualization = null;
    var _dynahide_counter = 0;
    var _dynahide_factor = 0;
    var _basicTreeProperties = null;
    var _depth_collapse_level = -1;
    var _rank_collapse_level = -1;
    var _branch_length_collapse_level = -1;
    var _branch_length_collapse_data = {};
    var _external_nodes = 0;
    var _w = null;
    var _visualizations = null;
    var _id = null;
    var _offsetTop = 0;
    var _legendColorScales = {};
    var _legendShapeScales = {};
    var _legendSizeScales = {};
    var _showLegends = true;
    var _showColorPicker = false;
    var _colorPickerData = null;
    var _usedColorCategories = new Set();
    var _colorsForColorPicker = null;


    function branchLengthScaling(nodes, width) {

        if (_root.parent) {
            _root.parent.distToRoot = 0;
        }
        forester.preOrderTraversalAll(_root, function (n) {
            n.distToRoot = (n.parent ? n.parent.distToRoot : 0) + bl(n);
        });
        var distsToRoot = nodes.map(function (n) {
            return n.distToRoot;
        });

        var yScale = d3.scale.linear()
            .domain([0, d3.max(distsToRoot)])
            .range([0, width]);
        forester.preOrderTraversalAll(_root, function (n) {
            n.y = yScale(n.distToRoot);
        });
        return yScale;

        function bl(node) {
            if (!node.branch_length || node.branch_length < 0) {
                return 0;
            }
            return node.branch_length;
        }
    }

    function zoom() {
        if (d3.event.sourceEvent && d3.event.sourceEvent.shiftKey) {
            if (_scale === null) {
                _scale = _zoomListener.scale();
                _translate = _zoomListener.translate();
            }
        }
        else {
            if (_scale !== null && _translate !== null) {
                _zoomListener.scale(_scale);
                _zoomListener.translate(_translate);
                _svgGroup.attr('transform', 'translate(' + _translate + ')scale(' + _scale + ')');
                _scale = null;
                _translate = null;
            }
            else {
                _svgGroup.attr('transform', 'translate(' + d3.event.translate + ')scale(' + d3.event.scale + ')');
            }
        }
    }

    function centerNode(source, x) {
        var scale = _zoomListener.scale();
        if (!x) {
            x = -source.y0;
            x = x * scale + _displayWidth / 2;
        }
        var y = 0;
        d3.select('g')
            .attr('transform', 'translate(' + x + ',' + y + ')scale(' + scale + ')');
        _zoomListener.scale(scale);
        _zoomListener.translate([x, y]);
    }

    function calcMaxTreeLengthForDisplay() {
        return _settings.rootOffset + _options.nodeLabelGap + LABEL_SIZE_CALC_ADDITION + ( _maxLabelLength * _options.externalNodeFontSize * LABEL_SIZE_CALC_FACTOR );
    }

    function createVisualization(label,
                                 description,
                                 field,
                                 cladePropertyRef,
                                 isRegex,
                                 mapping,
                                 mappingFn, // mappingFn is a scale
                                 scaleType,
                                 altMappingFn) {
        if (arguments.length < 8) {
            throw( 'expected at least 8 arguments, got ' + arguments.length);
        }

        if (!label || label.length < 1) {
            throw( 'need to have label');
        }
        var visualization = {};
        visualization.label = label;
        if (description) {
            visualization.description = description;
        }
        if (field) {
            if (cladePropertyRef) {
                throw( 'need to have either field or clade property ref');
            }
            visualization.field = field;
        }
        else if (cladePropertyRef) {
            visualization.cladePropertyRef = cladePropertyRef;
        }
        else {
            throw( 'need to have either field or clade property ref');
        }
        visualization.isRegex = isRegex;
        if (mapping) {
            if (mappingFn) {
                throw( 'need to have either mapping or mappingFn');
            }
            visualization.mapping = mapping;
        }
        else if (mappingFn) {
            visualization.mappingFn = mappingFn;
            if (scaleType === ORDINAL_SCALE) {
                if (mappingFn.domain() && mappingFn.range() && mappingFn.domain().length > mappingFn.range().length) {
                    if (altMappingFn && altMappingFn.domain() && altMappingFn.range()) {
                        visualization.mappingFn = altMappingFn;
                        scaleType = LINEAR_SCALE;
                    }
                    else {
                        var s = cladePropertyRef ? cladePropertyRef : field;
                        console.log(WARNING + ': Ordinal scale mapping for ' + label + ' (' + s + '): domain > range: ' +
                            mappingFn.domain().length + ' > ' + mappingFn.range().length);
                    }
                }
            }
        }
        else {
            throw( 'need to have either mapping or mappingFn');
        }
        visualization.scaleType = scaleType;
        return visualization;
    }

    function initializeNodeVisualizations(np) {

        if (_nodeVisualizations) {
            for (var key in _nodeVisualizations) {
                if (_nodeVisualizations.hasOwnProperty(key)) {

                    var nodeVisualization = _nodeVisualizations[key];

                    if (nodeVisualization.label) {
                        var scaleType = '';
                        if (nodeVisualization.shapes &&
                            Array.isArray(nodeVisualization.shapes) &&
                            (nodeVisualization.shapes.length > 0 )) {
                            var shapeScale = null;
                            if (nodeVisualization.cladeRef && np[nodeVisualization.cladeRef] &&
                                forester.setToArray(np[nodeVisualization.cladeRef]).length > 0) {
                                shapeScale = d3.scale.ordinal()
                                    .range(nodeVisualization.shapes)
                                    .domain(forester.setToSortedArray(np[nodeVisualization.cladeRef]));
                                scaleType = ORDINAL_SCALE;
                            }
                            else if (nodeVisualization.field && np[nodeVisualization.field] &&
                                forester.setToArray(np[nodeVisualization.field]).length > 0) {
                                shapeScale = d3.scale.ordinal()
                                    .range(nodeVisualization.shapes)
                                    .domain(forester.setToSortedArray(np[nodeVisualization.field]));
                                scaleType = ORDINAL_SCALE;
                            }
                            if (shapeScale) {
                                addNodeShapeVisualization(nodeVisualization.label,
                                    nodeVisualization.description,
                                    nodeVisualization.field ? nodeVisualization.field : null,
                                    nodeVisualization.cladeRef ? nodeVisualization.cladeRef : null,
                                    nodeVisualization.regex,
                                    null,
                                    shapeScale,
                                    scaleType
                                );
                            }
                        }

                        if (nodeVisualization.colors) {
                            if (nodeVisualization.cladeRef && np[nodeVisualization.cladeRef] && forester.setToArray(np[nodeVisualization.cladeRef]).length > 0) {
                                var colorScale = null;
                                var altColorScale = null;

                                if (Array.isArray(nodeVisualization.colors)) {
                                    scaleType = LINEAR_SCALE;
                                    if (nodeVisualization.colors.length === 3) {
                                        colorScale = d3.scale.linear()
                                            .range(nodeVisualization.colors)
                                            .domain(forester.calcMinMeanMaxInSet(np[nodeVisualization.cladeRef]));
                                    }
                                    else if (nodeVisualization.colors.length === 2) {
                                        colorScale = d3.scale.linear()
                                            .range(nodeVisualization.colors)
                                            .domain(forester.calcMinMaxInSet(np[nodeVisualization.cladeRef]));
                                    }
                                    else {
                                        throw 'Number of colors has to be either 2 or 3';
                                    }
                                }

                                if (Array.isArray(nodeVisualization.colorsAlt)) {
                                    if (nodeVisualization.colorsAlt.length === 3) {
                                        altColorScale = d3.scale.linear()
                                            .range(nodeVisualization.colorsAlt)
                                            .domain(forester.calcMinMeanMaxInSet(np[nodeVisualization.cladeRef]));
                                    }
                                    else if (nodeVisualization.colorsAlt.length === 2) {
                                        altColorScale = d3.scale.linear()
                                            .range(nodeVisualization.colorsAlt)
                                            .domain(forester.calcMinMaxInSet(np[nodeVisualization.cladeRef]));
                                    }
                                    else {
                                        throw 'Number of colors has to be either 2 or 3';
                                    }
                                }

                                if (forester.isString(nodeVisualization.colors) && nodeVisualization.colors.length > 0) {
                                    scaleType = ORDINAL_SCALE;
                                    if (nodeVisualization.colors === 'category20') {
                                        colorScale = d3.scale.category20()
                                            .domain(forester.setToSortedArray(np[nodeVisualization.cladeRef]));
                                        _usedColorCategories.add('category20');
                                    }
                                    else if (nodeVisualization.colors === 'category20b') {
                                        colorScale = d3.scale.category20b()
                                            .domain(forester.setToSortedArray(np[nodeVisualization.cladeRef]));
                                        _usedColorCategories.add('category20b');
                                    }
                                    else if (nodeVisualization.colors === 'category20c') {
                                        colorScale = d3.scale.category20c()
                                            .domain(forester.setToSortedArray(np[nodeVisualization.cladeRef]));
                                        _usedColorCategories.add('category20c');
                                    }
                                    else if (nodeVisualization.colors === 'category10') {
                                        colorScale = d3.scale.category10()
                                            .domain(forester.setToSortedArray(np[nodeVisualization.cladeRef]));
                                        _usedColorCategories.add('category10');
                                    }
                                    else {
                                        throw 'do not know how to process ' + nodeVisualization.colors;
                                    }
                                }

                                if (colorScale) {
                                    addLabelColorVisualization(nodeVisualization.label,
                                        nodeVisualization.description,
                                        null,
                                        nodeVisualization.cladeRef,
                                        nodeVisualization.regex,
                                        null,
                                        colorScale,
                                        scaleType,
                                        altColorScale);

                                    addNodeFillColorVisualization(nodeVisualization.label,
                                        nodeVisualization.description,
                                        null,
                                        nodeVisualization.cladeRef,
                                        nodeVisualization.regex,
                                        null,
                                        colorScale,
                                        scaleType,
                                        altColorScale);

                                    addNodeBorderColorVisualization(nodeVisualization.label,
                                        nodeVisualization.description,
                                        null,
                                        nodeVisualization.cladeRef,
                                        nodeVisualization.regex,
                                        null,
                                        colorScale,
                                        scaleType,
                                        altColorScale);
                                }
                            }
                        }

                        if (nodeVisualization.sizes && Array.isArray(nodeVisualization.sizes) && (nodeVisualization.sizes.length > 0  )) {
                            if (nodeVisualization.cladeRef && np[nodeVisualization.cladeRef] && forester.setToArray(np[nodeVisualization.cladeRef]).length > 0) {
                                var sizeScale = null;
                                var scaleType = LINEAR_SCALE;
                                if (nodeVisualization.sizes.length === 3) {
                                    sizeScale = d3.scale.linear()
                                        .range(nodeVisualization.sizes)
                                        .domain(forester.calcMinMeanMaxInSet(np[nodeVisualization.cladeRef]));
                                }
                                else if (nodeVisualization.sizes.length === 2) {
                                    sizeScale = d3.scale.linear()
                                        .range(nodeVisualization.sizes)
                                        .domain(forester.calcMinMaxInSet(np[nodeVisualization.cladeRef]));
                                }
                                else {
                                    throw 'Number of sizes has to be either 2 or 3';
                                }
                                if (sizeScale) {
                                    addNodeSizeVisualization(nodeVisualization.label,
                                        nodeVisualization.description,
                                        null,
                                        nodeVisualization.cladeRef,
                                        nodeVisualization.regex,
                                        null,
                                        sizeScale,
                                        scaleType);
                                }
                            }
                        }
                    }
                }
            }
        }

    }

    function addNodeSizeVisualization(label,
                                      description,
                                      field,
                                      cladePropertyRef,
                                      isRegex,
                                      mapping,
                                      mappingFn,
                                      scaleType) {
        if (arguments.length != 8) {
            throw( 'expected 8 arguments, got ' + arguments.length);
        }
        if (!_visualizations) {
            _visualizations = {};
        }
        if (!_visualizations.nodeSize) {
            _visualizations.nodeSize = {};
        }
        if (_visualizations.nodeSize[label]) {
            throw('node size visualization for "' + label + '" already exists');
        }
        var vis = createVisualization(label,
            description,
            field,
            cladePropertyRef,
            isRegex,
            mapping,
            mappingFn,
            scaleType);
        if (vis) {
            _visualizations.nodeSize[vis.label] = vis;
        }
    }

    function addNodeFillColorVisualization(label,
                                           description,
                                           field,
                                           cladePropertyRef,
                                           isRegex,
                                           mapping,
                                           mappingFn,
                                           scaleType,
                                           altMappingFn) {
        if (arguments.length < 8) {
            throw( 'expected at least 8 arguments, got ' + arguments.length);
        }
        if (!_visualizations) {
            _visualizations = {};
        }
        if (!_visualizations.nodeFillColor) {
            _visualizations.nodeFillColor = {};
        }
        if (_visualizations.nodeFillColor[label]) {
            throw('node fill color visualization for "' + label + '" already exists');
        }
        var vis = createVisualization(label,
            description,
            field,
            cladePropertyRef,
            isRegex,
            mapping,
            mappingFn,
            scaleType,
            altMappingFn);
        if (vis) {
            _visualizations.nodeFillColor[vis.label] = vis;
        }
    }

    function addNodeBorderColorVisualization(label,
                                             description,
                                             field,
                                             cladePropertyRef,
                                             isRegex,
                                             mapping,
                                             mappingFn,
                                             scaleType,
                                             altMappingFn) {
        if (arguments.length < 8) {
            throw( 'expected at least 8 arguments, got ' + arguments.length);
        }
        if (!_visualizations) {
            _visualizations = {};
        }
        if (!_visualizations.nodeBorderColor) {
            _visualizations.nodeBorderColor = {};
        }
        if (_visualizations.nodeBorderColor[label]) {
            throw('node border color visualization for "' + label + '" already exists');
        }
        var vis = createVisualization(label,
            description,
            field,
            cladePropertyRef,
            isRegex,
            mapping,
            mappingFn,
            scaleType,
            altMappingFn);
        if (vis) {
            _visualizations.nodeBorderColor[vis.label] = vis;
        }
    }


    function addNodeShapeVisualization(label,
                                       description,
                                       field,
                                       cladePropertyRef,
                                       isRegex,
                                       mapping,
                                       mappingFn,
                                       scaleType) {
        if (arguments.length != 8) {
            throw( 'expected 8 arguments, got ' + arguments.length);
        }
        if (!_visualizations) {
            _visualizations = {};
        }
        if (!_visualizations.nodeShape) {
            _visualizations.nodeShape = {};
        }
        if (_visualizations.nodeShape[label]) {
            throw('node shape visualization for "' + label + '" already exists');
        }
        var vis = createVisualization(label,
            description,
            field,
            cladePropertyRef,
            isRegex,
            mapping,
            mappingFn,
            scaleType);
        if (vis) {
            _visualizations.nodeShape[vis.label] = vis;
        }
    }


    function addLabelColorVisualization(label,
                                        description,
                                        field,
                                        cladePropertyRef,
                                        isRegex,
                                        mapping,
                                        mappingFn,
                                        scaleType,
                                        altMappingFn) {
        if (arguments.length < 8) {
            throw( 'expected at least 8 arguments, got ' + arguments.length);
        }
        if (!_visualizations) {
            _visualizations = {};
        }
        if (!_visualizations.labelColor) {
            _visualizations.labelColor = {};
        }
        if (_visualizations.labelColor[label]) {
            throw('label color visualization for "' + label + '" already exists');
        }
        var vis = createVisualization(label,
            description,
            field,
            cladePropertyRef,
            isRegex,
            mapping,
            mappingFn,
            scaleType,
            altMappingFn);
        if (vis) {
            _visualizations.labelColor[vis.label] = vis;
        }
    }

    function resetVis() {
        forester.preOrderTraversal(_root, function (n) {
            n.hasVis = undefined;
        });
    }


    function removeColorLegend(id) {
        _baseSvg.selectAll('g.' + id).remove();
    }

    function removeShapeLegend(id) {
        _baseSvg.selectAll('g.' + id).remove();
    }

    function removeSizeLegend(id) {
        _baseSvg.selectAll('g.' + id).remove();
    }

    function makeColorLegend(id, xPos, yPos, colorScale, scaleType, label, description) {

        if (!label) {
            throw 'legend label is missing';
        }

        var linearRangeLabel = ' (gradient)';
        var outOfRangeSymbol = ' *';
        var isLinearRange = scaleType === LINEAR_SCALE;
        var linearRangeLength = 0;
        if (isLinearRange) {
            label += linearRangeLabel;
            linearRangeLength = colorScale.domain().length;
        }
        else {
            if (colorScale.domain().length > colorScale.range().length) {
                label += outOfRangeSymbol;
            }
        }

        var counter = 0;

        var legendRectSize = 10;
        var legendSpacing = 4;

        var xCorrectionForLabel = -1;
        var yFactorForLabel = -1.5;
        var yFactorForDesc = -0.5;

        var legend = _baseSvg.selectAll('g.' + id)
            .data(colorScale.domain());

        var legendEnter = legend.enter().append('g')
            .attr('class', id);

        var fs = _settings.controlsFontSize.toString() + 'px';

        legendEnter.append('rect')
            .style('cursor', 'pointer')
            .attr('width', null)
            .attr('height', null)
            .on('click', function (clickedName, clickedIndex) {
                legendColorRectClicked(colorScale, label, description, clickedName, clickedIndex);
            });

        legendEnter.append('text')
            .attr('class', LEGEND)
            .style('color', _settings.controlsFontColor)
            .style('font-size', fs)
            .style('font-family', _settings.controlsFont)
            .style('font-style', 'normal')
            .style('font-weight', 'normal')
            .style('text-decoration', 'none');

        legendEnter.append('text')
            .attr('class', LEGEND_LABEL)
            .style('color', _settings.controlsFontColor)
            .style('font-size', fs)
            .style('font-family', _settings.controlsFont)
            .style('font-style', 'normal')
            .style('font-weight', 'bold')
            .style('text-decoration', 'none');

        legendEnter.append('text')
            .attr('class', LEGEND_DESCRIPTION)
            .style('color', _settings.controlsFontColor)
            .style('font-size', fs)
            .style('font-family', _settings.controlsFont)
            .style('font-style', 'normal')
            .style('font-weight', 'bold')
            .style('text-decoration', 'none');


        var legendUpdate = legend.transition()
            .duration(0)
            .attr('transform', function (d, i) {
                ++counter;
                var height = legendRectSize;
                var x = xPos;
                var y = yPos + i * height;
                return 'translate(' + x + ',' + y + ')';
            });

        legendUpdate.select('rect')
            .attr('width', legendRectSize)
            .attr('height', legendRectSize)
            .style('fill', colorScale)
            .style('stroke', colorScale);

        legendUpdate.select('text.' + LEGEND)
            .attr('x', legendRectSize + legendSpacing)
            .attr('y', legendRectSize - legendSpacing)
            .text(function (d, i) {
                if (isLinearRange) {
                    if (i === 0) {
                        return d + ' (min)';
                    }
                    else if (((linearRangeLength === 2 && i === 1) ||
                        (linearRangeLength === 3 && i === 2)  )) {
                        return d + ' (max)';
                    }
                    else if (linearRangeLength === 3 && i === 1) {
                        return preciseRound(d, 4) + ' (mean)';
                    }
                }
                return d;
            });

        legendUpdate.select('text.' + LEGEND_LABEL)
            .attr('x', xCorrectionForLabel)
            .attr('y', yFactorForLabel * legendRectSize)
            .text(function (d, i) {
                if (i === 0) {
                    return label;
                }
            });

        legendUpdate.select('text.' + LEGEND_DESCRIPTION)
            .attr('x', xCorrectionForLabel)
            .attr('y', yFactorForDesc * legendRectSize)
            .text(function (d, i) {
                if (i === 0 && description) {
                    return description;
                }
            });


        legend.exit().remove();

        return counter;
    }

    function makeShapeLegend(id, xPos, yPos, shapeScale, label, description) {

        if (!label) {
            throw 'legend label is missing';
        }

        var outOfRangeSymbol = ' *';

        if (shapeScale.domain().length > shapeScale.range().length) {
            label += outOfRangeSymbol;
        }

        var counter = 0;

        var legendRectSize = 10;
        var legendSpacing = 4;

        var xCorrectionForLabel = -1;
        var yFactorForLabel = -1.5;
        var yFactorForDesc = -0.5;

        var legend = _baseSvg.selectAll('g.' + id)
            .data(shapeScale.domain());

        var legendEnter = legend.enter().append('g')
            .attr('class', id);

        var fs = _settings.controlsFontSize.toString() + 'px';

        legendEnter.append('path');

        legendEnter.append('text')
            .attr('class', LEGEND)
            .style('color', _settings.controlsFontColor)
            .style('font-size', fs)
            .style('font-family', _settings.controlsFont)
            .style('font-style', 'normal')
            .style('font-weight', 'normal')
            .style('text-decoration', 'none');

        legendEnter.append('text')
            .attr('class', LEGEND_LABEL)
            .style('color', _settings.controlsFontColor)
            .style('font-size', fs)
            .style('font-family', _settings.controlsFont)
            .style('font-style', 'normal')
            .style('font-weight', 'bold')
            .style('text-decoration', 'none');

        legendEnter.append('text')
            .attr('class', LEGEND_DESCRIPTION)
            .style('color', _settings.controlsFontColor)
            .style('font-size', fs)
            .style('font-family', _settings.controlsFont)
            .style('font-style', 'normal')
            .style('font-weight', 'bold')
            .style('text-decoration', 'none');

        var legendUpdate = legend
            .attr('transform', function (d, i) {
                ++counter;
                var height = legendRectSize;
                var x = xPos;
                var y = yPos + i * height;
                return 'translate(' + x + ',' + y + ')';
            });

        var values = [];

        legendUpdate.select('text.' + LEGEND)
            .attr('x', legendRectSize + legendSpacing)
            .attr('y', legendRectSize - legendSpacing)
            .text(function (d) {
                values.push(d);
                return d;
            });

        legendUpdate.select('text.' + LEGEND_LABEL)
            .attr('x', xCorrectionForLabel)
            .attr('y', yFactorForLabel * legendRectSize)
            .text(function (d, i) {
                if (i === 0) {
                    return label;
                }
            });

        legendUpdate.select('text.' + LEGEND_DESCRIPTION)
            .attr('x', xCorrectionForLabel)
            .attr('y', yFactorForDesc * legendRectSize)
            .text(function (d, i) {
                if (i === 0 && description) {
                    return description;
                }
            });

        legendUpdate.select('path')
            .attr('transform', function () {
                return 'translate(' + 1 + ',' + 3 + ')'
            })
            .attr('d', d3.svg.symbol()
                .size(function () {
                    return 20;
                })
                .type(function (d, i) {
                    return shapeScale(values[i]);
                }))
            .style('fill', 'none')
            .style('stroke', _options.branchColorDefault);


        legend.exit().remove();

        return counter;
    }


    function makeSizeLegend(id, xPos, yPos, sizeScale, scaleType, label, description) {
        if (!label) {
            throw 'legend label is missing';
        }
        var linearRangeLabel = ' (range)';
        var isLinearRange = scaleType === LINEAR_SCALE;
        var linearRangeLength = 0;
        if (isLinearRange) {
            label += linearRangeLabel;
            linearRangeLength = sizeScale.domain().length;
        }

        var counter = 0;

        var legendRectSize = 10;
        var legendSpacing = 4;

        var xCorrectionForLabel = -1;
        var yFactorForLabel = -1.5;
        var yFactorForDesc = -0.5;

        var legend = _baseSvg.selectAll('g.' + id)
            .data(sizeScale.domain());

        var legendEnter = legend.enter().append('g')
            .attr('class', id);

        var fs = _settings.controlsFontSize.toString() + 'px';

        legendEnter.append('path');

        legendEnter.append('text')
            .attr('class', LEGEND)
            .style('color', _settings.controlsFontColor)
            .style('font-size', fs)
            .style('font-family', _settings.controlsFont)
            .style('font-style', 'normal')
            .style('font-weight', 'normal')
            .style('text-decoration', 'none');

        legendEnter.append('text')
            .attr('class', LEGEND_LABEL)
            .style('color', _settings.controlsFontColor)
            .style('font-size', fs)
            .style('font-family', _settings.controlsFont)
            .style('font-style', 'normal')
            .style('font-weight', 'bold')
            .style('text-decoration', 'none');

        legendEnter.append('text')
            .attr('class', LEGEND_DESCRIPTION)
            .style('color', _settings.controlsFontColor)
            .style('font-size', fs)
            .style('font-family', _settings.controlsFont)
            .style('font-style', 'normal')
            .style('font-weight', 'bold')
            .style('text-decoration', 'none');

        var legendUpdate = legend
            .attr('transform', function (d, i) {
                ++counter;
                var height = legendRectSize;
                var x = xPos;
                var y = yPos + i * height;
                return 'translate(' + x + ',' + y + ')';
            });

        var values = [];

        legendUpdate.select('text.' + LEGEND)
            .attr('x', legendRectSize + legendSpacing)
            .attr('y', legendRectSize - legendSpacing)
            .text(function (d, i) {
                values.push(d);
                if (isLinearRange) {
                    if (i === 0) {
                        return d + ' (min)';
                    }
                    else if (((linearRangeLength === 2 && i === 1) ||
                        (linearRangeLength === 3 && i === 2)  )) {
                        return d + ' (max)';
                    }
                    else if (linearRangeLength === 3 && i === 1) {
                        return preciseRound(d, 4) + ' (mean)';
                    }
                }
                return d;
            });

        legendUpdate.select('text.' + LEGEND_LABEL)
            .attr('x', xCorrectionForLabel)
            .attr('y', yFactorForLabel * legendRectSize)
            .text(function (d, i) {
                if (i === 0) {
                    return label;
                }
            });

        legendUpdate.select('text.' + LEGEND_DESCRIPTION)
            .attr('x', xCorrectionForLabel)
            .attr('y', yFactorForDesc * legendRectSize)
            .text(function (d, i) {
                if (i === 0 && description) {
                    return description;
                }
            });

        legendUpdate.select('path')
            .attr('transform', function () {
                return 'translate(' + 1 + ',' + 3 + ')'
            })
            .attr('d', d3.svg.symbol()
                .size(function (d, i) {
                    var scale = _zoomListener.scale();
                    return scale * _options.nodeSizeDefault * sizeScale(values[i]);
                })
                .type(function () {
                    return 'circle';
                }))
            .style('fill', 'none')
            .style('stroke', _options.branchColorDefault);

        legend.exit().remove();

        return counter;
    }

    function preciseRound(num, decimals) {
        var t = Math.pow(10, decimals);
        return (Math.round((num * t) + (decimals > 0 ? 1 : 0) * (Math.sign(num) * (10 / Math.pow(100, decimals)))) / t).toFixed(decimals);
    }

    function addLegends() {
        var xPos = _options.visualizationsLegendXpos;
        var yPos = _options.visualizationsLegendYpos;
        var xPosIncr = 0;
        var yPosIncr = 0;
        var yPosIncrConst = 0;
        if (_options.visualizationsLegendOrientation === HORIZONTAL) {
            xPosIncr = 130;
        }
        else if (_options.visualizationsLegendOrientation === VERTICAL) {
            yPosIncr = 10;
            yPosIncrConst = 40;
        }
        else {
            throw ('unknown direction for legends ' + _options.visualizationsLegendOrientation);
        }
        var label = '';
        var desc = '';
        var counter = 0;
        var scaleType = '';

        if (_showLegends && _legendColorScales[LEGEND_LABEL_COLOR]) {
            removeColorLegend(LEGEND_LABEL_COLOR);
            label = 'Label Color';
            desc = _currentLabelColorVisualization;
            scaleType = _visualizations.labelColor[_currentLabelColorVisualization].scaleType;
            counter = makeColorLegend(LEGEND_LABEL_COLOR,
                xPos, yPos,
                _legendColorScales[LEGEND_LABEL_COLOR],
                scaleType,
                label, desc);
            xPos += xPosIncr;
            yPos += ((counter * yPosIncr ) + yPosIncrConst);
        }
        else {
            removeColorLegend(LEGEND_LABEL_COLOR);
        }

        if (_showLegends && _options.showNodeVisualizations && _legendColorScales[LEGEND_NODE_FILL_COLOR]) {
            removeColorLegend(LEGEND_NODE_FILL_COLOR);
            label = 'Node Fill';
            desc = _currentNodeFillColorVisualization;
            scaleType = _visualizations.nodeFillColor[_currentNodeFillColorVisualization].scaleType;

            counter = makeColorLegend(LEGEND_NODE_FILL_COLOR,
                xPos, yPos,
                _legendColorScales[LEGEND_NODE_FILL_COLOR],
                scaleType,
                label, desc);
            xPos += xPosIncr;
            yPos += ((counter * yPosIncr ) + yPosIncrConst);
        }
        else {
            removeColorLegend(LEGEND_NODE_FILL_COLOR);
        }

        if (_showLegends && _options.showNodeVisualizations && _legendColorScales[LEGEND_NODE_BORDER_COLOR]) {
            removeColorLegend(LEGEND_NODE_BORDER_COLOR);
            label = 'Node Border';
            desc = _currentNodeBorderColorVisualization;
            scaleType = _visualizations.nodeBorderColor[_currentNodeBorderColorVisualization].scaleType;

            counter = makeColorLegend(LEGEND_NODE_BORDER_COLOR,
                xPos, yPos,
                _legendColorScales[LEGEND_NODE_BORDER_COLOR],
                scaleType,
                label, desc);
            xPos += xPosIncr;
            yPos += ((counter * yPosIncr ) + yPosIncrConst);
        }
        else {
            removeColorLegend(LEGEND_NODE_BORDER_COLOR);
        }

        if (_showLegends && _options.showNodeVisualizations && _legendShapeScales[LEGEND_NODE_SHAPE]) {
            label = 'Node Shape';
            desc = _currentNodeShapeVisualization;
            counter = makeShapeLegend(LEGEND_NODE_SHAPE, xPos, yPos, _legendShapeScales[LEGEND_NODE_SHAPE], label, desc);
            xPos += xPosIncr;
            yPos += ((counter * yPosIncr ) + yPosIncrConst);
        }
        else {
            removeShapeLegend(LEGEND_NODE_SHAPE);
        }

        if (_showLegends && _options.showNodeVisualizations && _legendSizeScales[LEGEND_NODE_SIZE]) {
            label = 'Node Size';
            desc = _currentNodeSizeVisualization;
            scaleType = _visualizations.nodeSize[_currentNodeSizeVisualization].scaleType;
            makeSizeLegend(LEGEND_NODE_SIZE, xPos, yPos, _legendSizeScales[LEGEND_NODE_SIZE], scaleType, label, desc);
        }
        else {
            removeSizeLegend(LEGEND_NODE_SIZE);
        }

    }


    // --------------------------------------------------------------
    // Functions for color picker
    // --------------------------------------------------------------
    function obtainPredefinedColors(name) {
        var t = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19];
        var colorScale = null;
        var l = 0;
        if (name === 'category20') {
            l = 20;
            colorScale = d3.scale.category20()
                .domain(t);
        }
        else if (name === 'category20b') {
            l = 20;
            colorScale = d3.scale.category20b()
                .domain(t);
        }
        else if (name === 'category20c') {
            l = 20;
            colorScale = d3.scale.category20c()
                .domain(t);
        }
        else if (name === 'category10') {
            l = 10;
            colorScale = d3.scale.category10()
                .domain([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
        }
        else {
            throw 'do not know ' + name;
        }
        var colors = [];
        for (var i = 0; i < l; ++i) {
            colors.push(colorScale(i));
        }
        return colors;
    }

    function addColorPicker(targetScale, legendLabel, legendDescription, clickedName, clickedIndex) {
        _colorPickerData = {};
        _colorPickerData.targetScale = targetScale;
        _colorPickerData.legendLabel = legendLabel;
        _colorPickerData.legendDescription = legendDescription;
        _colorPickerData.clickedName = clickedName;
        _colorPickerData.clickedIndex = clickedIndex;
        _colorPickerData.clickedOrigColor = targetScale(clickedName);
        _showColorPicker = true;
    }

    function removeColorPicker() {
        _showColorPicker = false;
        _colorPickerData = null;
        _baseSvg.selectAll('g.' + COLOR_PICKER).remove();
    }

    function prepareColorsForColorPicker() {
        var DEFAULT_COLORS_FOR_COLORPICKER = [
            // Red
            '#FFEBEE', '#FFCDD2', '#EF9A9A', '#E57373', '#EF5350', '#F44336', '#E53935', '#D32F2F', '#C62828', '#B71C1C', '#FF8A80', '#FF5252', '#FF1744', '#D50000',
            // Pink
            '#FCE4EC', '#F8BBD0', '#F48FB1', '#F06292', '#EC407A', '#E91E63', '#D81B60', '#C2185B', '#AD1457', '#880E4F', '#FF80AB', '#FF4081', '#F50057', '#C51162',
            // Purple
            '#F3E5F5', '#E1BEE7', '#CE93D8', '#BA68C8', '#AB47BC', '#9C27B0', '#8E24AA', '#7B1FA2', '#6A1B9A', '#4A148C', '#EA80FC', '#E040FB', '#D500F9', '#AA00FF',
            // Deep Purple
            '#EDE7F6', '#D1C4E9', '#B39DDB', '#9575CD', '#7E57C2', '#673AB7', '#5E35B1', '#512DA8', '#4527A0', '#311B92', '#B388FF', '#7C4DFF', '#651FFF', '#6200EA',
            // Indigo
            '#E8EAF6', '#C5CAE9', '#9FA8DA', '#7986CB', '#5C6BC0', '#3F51B5', '#3949AB', '#303F9F', '#283593', '#1A237E', '#8C9EFF', '#536DFE', '#3D5AFE', '#304FFE',
            // Blue
            '#E3F2FD', '#BBDEFB', '#90CAF9', '#64B5F6', '#42A5F5', '#2196F3', '#1E88E5', '#1976D2', '#1565C0', '#0D47A1', '#82B1FF', '#448AFF', '#2979FF', '#2962FF',
            // Light Blue
            '#E1F5FE', '#B3E5FC', '#81D4FA', '#4FC3F7', '#29B6F6', '#03A9F4', '#039BE5', '#0288D1', '#0277BD', '#01579B', '#80D8FF', '#40C4FF', '#00B0FF', '#0091EA',
            // Cyan
            '#E0F7FA', '#B2EBF2', '#80DEEA', '#4DD0E1', '#26C6DA', '#00BCD4', '#00ACC1', '#0097A7', '#00838F', '#006064', '#84FFFF', '#18FFFF', '#00E5FF', '#00B8D4',
            // Teal
            '#E0F2F1', '#B2DFDB', '#80CBC4', '#4DB6AC', '#26A69A', '#009688', '#00897B', '#00796B', '#00695C', '#004D40', '#A7FFEB', '#64FFDA', '#1DE9B6', '#00BFA5',
            // Green
            '#E8F5E9', '#C8E6C9', '#A5D6A7', '#81C784', '#66BB6A', '#4CAF50', '#43A047', '#388E3C', '#2E7D32', '#1B5E20', '#B9F6CA', '#69F0AE', '#00E676', '#00C853',
            // Light Green
            '#F1F8E9', '#DCEDC8', '#C5E1A5', '#AED581', '#9CCC65', '#8BC34A', '#7CB342', '#689F38', '#558B2F', '#33691E', '#CCFF90', '#B2FF59', '#76FF03', '#64DD17',
            // Lime
            '#F9FBE7', '#F0F4C3', '#E6EE9C', '#DCE775', '#D4E157', '#CDDC39', '#C0CA33', '#AFB42B', '#9E9D24', '#827717', '#F4FF81', '#EEFF41', '#C6FF00', '#AEEA00',
            // Yellow
            '#FFFDE7', '#FFF9C4', '#FFF59D', '#FFF176', '#FFEE58', '#FFEB3B', '#FDD835', '#FBC02D', '#F9A825', '#F57F17', '#FFFF8D', '#FFFF00', '#FFEA00', '#FFD600',
            // Amber
            '#FFF8E1', '#FFECB3', '#FFE082', '#FFD54F', '#FFCA28', '#FFC107', '#FFB300', '#FFA000', '#FF8F00', '#FF6F00', '#FFE57F', '#FFD740', '#FFC400', '#FFAB00',
            // Orange
            '#FFF3E0', '#FFE0B2', '#FFCC80', '#FFB74D', '#FFA726', '#FF9800', '#FB8C00', '#F57C00', '#EF6C00', '#E65100', '#FFD180', '#FFAB40', '#FF9100', '#FF6D00',
            // Deep Orange
            '#FBE9E7', '#FFCCBC', '#FFAB91', '#FF8A65', '#FF7043', '#FF5722', '#F4511E', '#E64A19', '#D84315', '#BF360C', '#FF9E80', '#FF6E40', '#FF3D00', '#DD2C00',
            // Brown
            '#EFEBE9', '#D7CCC8', '#BCAAA4', '#A1887F', '#8D6E63', '#795548', '#6D4C41', '#5D4037', '#4E342E', '#3E2723',
            // Grey
            '#FAFAFA', '#F5F5F5', '#EEEEEE', '#E0E0E0', '#BDBDBD', '#9E9E9E', '#757575', '#616161', '#424242', '#212121',
            // Blue Grey
            '#ECEFF1', '#CFD8DC', '#B0BEC5', '#90A4AE', '#78909C', '#607D8B', '#546E7A', '#455A64', '#37474F', '#263238',
            // Basic
            '#FFFFFF', '#999999', '#000000', '#FF0000', '#00FF00', '#0000FF', '#FF00FF', '#FFFF00', '#00FFFF', _options.backgroundColorDefault
        ];
        _colorsForColorPicker = [];

        var dcpl = DEFAULT_COLORS_FOR_COLORPICKER.length;
        for (var dci = 0; dci < dcpl; ++dci) {
            _colorsForColorPicker.push(DEFAULT_COLORS_FOR_COLORPICKER[dci]);
        }

        _usedColorCategories.forEach(function (e) {
            var cs = obtainPredefinedColors(e);
            var csl = cs.length;
            for (var csi = 0; csi < csl; ++csi) {
                _colorsForColorPicker.push(cs[csi]);
            }
        });
    }

    function makeColorPicker(id) {

        var xPos = 0;
        var yPos = 0;

        if (_options.visualizationsLegendOrientation === VERTICAL) {
            xPos = _options.visualizationsLegendXpos + 140;
            yPos = _options.visualizationsLegendYpos - 10;
        }
        else {
            xPos = _options.visualizationsLegendXpos;
            yPos = _options.visualizationsLegendYpos + 180;
        }

        if (xPos < 20) {
            xPos = 20;
        }
        if (yPos < 20) {
            yPos = 20;
        }

        if (!_colorsForColorPicker) {
            prepareColorsForColorPicker();
        }

        var fs = _settings.controlsFontSize.toString() + 'px';

        var clickedOrigColorIndex = -1;

        var lbls = [];
        for (var ii = 0; ii < _colorsForColorPicker.length; ++ii) {
            lbls[ii] = ii;
            if (clickedOrigColorIndex < 0 && (colorToHex(_colorsForColorPicker[ii]) === colorToHex(_colorPickerData.clickedOrigColor))) {
                clickedOrigColorIndex = ii;
            }
        }

        var colorPickerColors = d3.scale.linear()
            .domain(lbls)
            .range(_colorsForColorPicker);

        var colorPickerSize = 14;
        var rectSize = 10;

        var xCorrectionForLabel = -1;
        var yFactorForDesc = -0.5;

        var colorPicker = _baseSvg.selectAll('g.' + id)
            .data(colorPickerColors.domain());

        var colorPickerEnter = colorPicker.enter().append('g')
            .attr('class', id);

        colorPickerEnter.append('rect')
            .style('cursor', 'pointer')
            .attr('width', null)
            .attr('height', null)
            .on('click', function (d, i) {
                colorPickerClicked(colorPickerColors(d));
            });

        colorPickerEnter.append('text')
            .attr('class', COLOR_PICKER_LABEL)
            .style('color', _settings.controlsFontColor)
            .style('font-size', fs)
            .style('font-family', _settings.controlsFont)
            .style('font-style', 'normal')
            .style('font-weight', 'bold')
            .style('text-decoration', 'none');

        var colorPickerUpdate = colorPicker
            .attr('transform', function (d, i) {
                if (i >= 234) {
                    i += 4;
                    if (i >= 248) {
                        i += 4;
                    }
                    if (i >= 262) {
                        i += 4;
                    }
                    if (i >= 276) {
                        i += 4;
                    }
                    if (i >= 290) {
                        i += 4;
                    }
                    if (i >= 304) {
                        i += 4;
                    }
                    if (i >= 318) {
                        i += 4;
                    }
                    if (i >= 332) {
                        i += 4;
                    }
                    if (i >= 346) {
                        i += 4;
                    }
                }
                var x = xPos + Math.floor(( i / colorPickerSize )) * rectSize;
                var y = yPos + (( i % colorPickerSize ) * rectSize);
                return 'translate(' + x + ',' + y + ')';
            });

        colorPickerUpdate.select('rect')
            .attr('width', rectSize)
            .attr('height', rectSize)
            .style('fill', colorPickerColors)
            .style('stroke',
                function (d, i) {
                    if (i === clickedOrigColorIndex) {
                        return COLOR_PICKER_CLICKED_ORIG_COLOR_BORDER_COLOR;
                    }
                    else if (i === 263) {
                        return COLOR_PICKER_BACKGROUND_BORDER_COLOR;
                    }
                    return WHITE;
                }
            );

        colorPickerUpdate.select('text.' + COLOR_PICKER_LABEL)
            .attr('x', xCorrectionForLabel)
            .attr('y', yFactorForDesc * rectSize)
            .text(function (d, i) {
                if (i === 0) {
                    return 'Choose ' + _colorPickerData.legendLabel.toLowerCase() +
                        ' for ' + _colorPickerData.legendDescription.toLowerCase() + ' "' +
                        _colorPickerData.clickedName + '":';
                }
            });

        colorPicker.exit().remove();

        function colorToHex(color) {
            // From http://stackoverflow.com/questions/1573053/javascript-function-to-convert-color-names-to-hex-codes
            // Convert any CSS color to a hex representation
            var rgba, hex;
            rgba = colorToRGBA(color);
            hex = [0, 1, 2].map(
                function (idx) {
                    return byteToHex(rgba[idx]);
                }
            ).join('');
            return '#' + hex;

            function colorToRGBA(color) {
                var cvs, ctx;
                cvs = document.createElement('canvas');
                cvs.height = 1;
                cvs.width = 1;
                ctx = cvs.getContext('2d');
                ctx.fillStyle = color;
                ctx.fillRect(0, 0, 1, 1);
                return ctx.getImageData(0, 0, 1, 1).data;
            }

            function byteToHex(num) {
                return ('0' + num.toString(16)).slice(-2);
            }
        }

    } // makeColorPicker


    function colorPickerClicked(colorPicked) {

        var vis = _visualizations.labelColor[_colorPickerData.legendDescription];
        var mf = vis.mappingFn;

        var scaleType = vis.scaleType;
        var domain = null;
        var newColorRange = null;
        var curName = null;
        if (scaleType === ORDINAL_SCALE) {
            var ord = _colorPickerData.targetScale;
            domain = ord.domain();
            newColorRange = [];
            for (var di = 0; di < domain.length; ++di) {
                curName = domain[di];
                if (curName === _colorPickerData.clickedName) {
                    newColorRange[di] = colorPicked;
                }
                else {
                    newColorRange[di] = ord(curName);
                }
            }
            mf.range(newColorRange);
        }
        else if (scaleType === LINEAR_SCALE) {
            var lin = _colorPickerData.targetScale;
            domain = lin.domain();
            newColorRange = [];
            for (var dii = 0; dii < domain.length; ++dii) {
                curName = domain[dii];
                if (curName === _colorPickerData.clickedName) {
                    newColorRange[dii] = colorPicked;
                }
                else {
                    newColorRange[dii] = lin(curName);
                }
            }
            mf.range(newColorRange);
        }

        update();
    }

    // --------------------------------------------------------------


    function update(source, transitionDuration, doNotRecalculateWidth) {

        if (!source) {
            source = _root;
        }
        if (transitionDuration === undefined) {
            transitionDuration = TRANSITION_DURATION_DEFAULT;
        }

        if ((!doNotRecalculateWidth || doNotRecalculateWidth === false) || !_w) {
            _w = _displayWidth - calcMaxTreeLengthForDisplay();
            if (_w < 1) {
                _w = 1;
            }
        }

        if (_settings.enableNodeVisualizations) {
            addLegends();
            if (_showColorPicker) {
                makeColorPicker(COLOR_PICKER);
            }
        }

        _treeFn = _treeFn.size([_displayHeight, _w]);

        _treeFn = _treeFn.separation(function separation(a, b) {
            return a.parent == b.parent ? 1 : 1;
        });

        _external_nodes = forester.calcSumOfAllExternalDescendants(_root);
        var uncollsed_nodes = forester.calcSumOfExternalDescendants(_root);

        var nodes = _treeFn.nodes(_root).reverse();
        var links = _treeFn.links(nodes);
        var gap = _options.nodeLabelGap;

        if (_options.phylogram === true) {
            _yScale = branchLengthScaling(forester.getAllExternalNodes(_root), _w);
        }

        if (_options.dynahide) {
            _dynahide_counter = 0;
            _dynahide_factor = Math.round(_options.externalNodeFontSize / ( ( 0.8 * _displayHeight) / uncollsed_nodes ));
            forester.preOrderTraversal(_root, function (n) {
                if (!n.children && _dynahide_factor >= 2 && (++_dynahide_counter % _dynahide_factor !== 0)) {
                    n.hide = true;
                }
                else {
                    n.hide = false;
                }
            });
        }

        updateDepthCollapseDepthDisplay();
        updateBranchLengthCollapseBranchLengthDisplay();
        updateButtonEnabledState();
        if (_settings.enableNodeVisualizations || _settings.enableBranchVisualizations) {
            updateLegendButtonEnabledState();
        }

        var node = _svgGroup.selectAll("g.node")
            .data(nodes, function (d) {
                return d.id || (d.id = ++_i);
            });

        var nodeEnter = node.enter().append("g")
            .attr('class', "node")
            .attr('transform', function () {
                return "translate(" + source.y0 + "," + source.x0 + ")";
            })
            .style('cursor', 'default')
            .on('click', _treeFn.clickEvent);

        nodeEnter.append('path')
            .attr('d', 'M0,0');

        nodeEnter.append('circle')
            .attr('class', 'nodeCircle')
            .attr("r", 0);

        nodeEnter.append('circle')
            .style('cursor', 'pointer')
            .style('opacity', "0")
            .attr('class', 'nodeCircleOptions')
            .attr("r", function (d) {
                if (d.parent) {
                    return 5;
                }
                return 0;
            });

        nodeEnter.append('text')
            .attr('class', "extlabel")
            .attr('text-anchor', function (d) {
                return d.children || d._children ? "end" : "start";
            })
            .style('font-family', _options.defaultFont)
            .style('font-style', 'normal')
            .style('font-weight', 'normal')
            .style('text-decoration', 'none')
            .style('fill-opacity', 0.5);

        nodeEnter.append('text')
            .attr('class', "bllabel")
            .style('font-family', _options.defaultFont)
            .style('font-style', 'normal')
            .style('font-weight', 'normal')
            .style('text-decoration', 'none')
            .style('fill-opacity', 0.5);

        nodeEnter.append('text')
            .attr('class', "conflabel")
            .attr('text-anchor', 'middle')
            .style('font-family', _options.defaultFont)
            .style('font-style', 'normal')
            .style('font-weight', 'normal')
            .style('text-decoration', 'none');

        nodeEnter.append('text')
            .attr('class', "brancheventlabel")
            .attr('text-anchor', 'middle')
            .style('font-family', _options.defaultFont)
            .style('font-style', 'normal')
            .style('font-weight', 'normal')
            .style('text-decoration', 'none');

        nodeEnter.append('text')
            .attr('class', 'collapsedText')
            .attr('dy', function (d) {
                return 0.3 * _options.externalNodeFontSize + 'px';
            })
            .style('font-family', _options.defaultFont)
            .style('font-style', 'normal')
            .style('font-weight', 'normal')
            .style('text-decoration', 'none');

        node.select("text.extlabel")
            .style('font-size', function (d) {
                return d.children || d._children ? _options.internalNodeFontSize + 'px' : _options.externalNodeFontSize + 'px';
            })
            .style('fill', makeLabelColor)
            .attr('dy', function (d) {
                return d.children || d._children ? 0.3 * _options.internalNodeFontSize + 'px' : 0.3 * _options.externalNodeFontSize + 'px';
            })
            .attr('x', function (d) {
                if (!(d.children || d._children)) {
                    if (_options.phylogram && _options.alignPhylogram) {
                        return (-_yScale(d.distToRoot) + _w + gap);
                    }
                    else {
                        return gap;
                    }
                }
                else {
                    return -gap;
                }
            });

        node.select('text.bllabel')
            .style('font-size', _options.branchDataFontSize + 'px')
            .attr('dy', '-.25em')
            .attr('x', function (d) {
                if (d.parent) {
                    return (d.parent.y - d.y + 1);
                }
                else {
                    return 0;
                }
            });

        node.select('text.conflabel')
            .style('font-size', _options.branchDataFontSize + 'px')
            .attr('dy', _options.branchDataFontSize)
            .attr('x', function (d) {
                if (d.parent) {
                    return (0.5 * (d.parent.y - d.y) );
                }
                else {
                    return 0;
                }
            });

        node.select('text.brancheventlabel')
            .style('font-size', _options.branchDataFontSize + 'px')
            .attr('dy', '-.25em')
            .attr('x', function (d) {
                if (d.parent) {
                    return (0.5 * (d.parent.y - d.y) );
                }
            });

        node.select('circle.nodeCircle')
            .attr('r', function (d) {
                if (( (_options.showNodeVisualizations && !_options.showNodeEvents ) &&
                    (makeNodeStrokeColor(d) === _options.backgroundColorDefault &&
                    makeNodeFillColor(d) === _options.backgroundColorDefault ) )) {
                    return 0;
                }
                return makeNodeSize(d);
            })
            .style('stroke', function (d) {
                return makeNodeStrokeColor(d);
            })
            .style('stroke-width', _options.branchWidthDefault)
            .style('fill', function (d) {
                return ( _options.showNodeVisualizations || _options.showNodeEvents || isNodeFound(d)) ? makeNodeFillColor(d) : _options.backgroundColorDefault;
            });


        var start = _options.phylogram ? (-1) : (-10);
        var ylength = _displayHeight / ( 3 * uncollsed_nodes );

        var nodeUpdate = node.transition()
            .duration(transitionDuration)
            .attr('transform', function (d) {
                return 'translate(' + d.y + ',' + d.x + ')';
            });

        nodeUpdate.select('text')
            .style('fill-opacity', 1);

        nodeUpdate.select('text.extlabel')
            .text(function (d) {
                if (!_options.dynahide || !d.hide) {
                    return makeNodeLabel(d);
                }
            });

        nodeUpdate.select('text.bllabel')
            .text(_options.showBranchLengthValues ? makeBranchLengthLabel : null);

        nodeUpdate.select('text.conflabel')
            .text(_options.showConfidenceValues ? makeConfidenceValuesLabel : null);

        nodeUpdate.select('text.brancheventlabel')
            .text(_options.showBranchEvents ? makeBranchEventsLabel : null);

        nodeUpdate.select('path')
            .style('stroke', _options.showNodeVisualizations ? makeVisNodeBorderColor : null)
            .style('stroke-width', _options.branchWidthDefault)
            .style('fill', _options.showNodeVisualizations ? makeVisNodeFillColor : null)
            .style('opacity', _options.nodeVisualizationsOpacity)
            .attr('d', _options.showNodeVisualizations ? makeNodeVisShape : null);


        node.each(function (d) {
            if (d._children) {
                var yl = ylength;
                var descs = forester.getAllExternalNodes(d);
                if (descs.length < 5) {
                    yl = 0.5 * yl;
                }
                var avg = forester.calcAverageTreeHeight(d, descs);

                var xlength = _options.phylogram ? _yScale(avg) : 0;
                d.avg = xlength;
                var l = d.width ? (d.width / 2) : _options.branchWidthDefault / 2;
                var collapsedColor = makeCollapsedColor(d);
                d3.select(this).select('path').transition().duration(transitionDuration)
                    .attr('d', function () {
                        return 'M' + start + ',' + (-l) + 'L' + xlength + ',' + (-yl) + 'L' + xlength + ',' + (yl) + 'L' + start + ',' + l + 'L' + start + ',' + (-l);
                    })
                    .style('stroke', collapsedColor)
                    .style('fill', collapsedColor);

                d3.select(this).select('.collapsedText').attr('font-size', function (d) {
                    return _options.externalNodeFontSize + 'px';
                });

                d3.select(this).select('.collapsedText').transition().duration(transitionDuration)
                    .style('fill-opacity', 1)
                    .text(makeCollapsedLabel(d, descs))
                    .style('fill', function (d) {
                        return makeLabelColorForCollapsed(d, collapsedColor);
                    })
                    .attr('dy', function (d) {
                        return 0.3 * _options.externalNodeFontSize + 'px';
                    })
                    .attr('x', function (d) {
                        if (_options.phylogram && _options.alignPhylogram) {
                            var w = d;
                            while (w.children && w.children.length > 0) {
                                w = w.children[0];
                            }
                            return (-_yScale(w.distToRoot) + _w + gap);
                        }
                        else {
                            return xlength + gap;
                        }
                    });

            }
            if (d.children) {
                if (!_options.showNodeVisualizations && makeNodeVisShape(d) === null) {
                    d3.select(this).select('path').transition().duration(transitionDuration)
                        .attr('d', function () {
                            return 'M0,0';
                        });
                }
                d3.select(this).select('.collapsedText').transition().duration(transitionDuration)
                    .attr('x', 0)
                    .style('fill-opacity', 1e-6)
                    .each('end', function () {
                        d3.select(this).text('');
                    });
            }
        });

        var nodeExit = node.exit().transition()
            .duration(transitionDuration)
            .attr('transform', function () {
                return "translate(" + source.y + "," + source.x + ")";
            })
            .remove();

        nodeExit.select('circle')
            .attr('r', 0);

        nodeExit.select('text')
            .style('fill-opacity', 0);

        var link = _svgGroup.selectAll('path.link')
            .attr('d', elbow)
            .attr('stroke-width', makeBranchWidth)
            .data(links, function (d) {
                return d.target.id;
            });

        link.enter().insert('path', 'g')
            .attr('class', 'link')
            .attr('fill', 'none')
            .attr('stroke-width', makeBranchWidth)
            .attr('stroke', makeBranchColor)
            .attr('d', function () {
                var o = {
                    x: source.x0,
                    y: source.y0
                };
                return elbow({
                    source: o,
                    target: o
                });
            });


        link.transition()
            .duration(transitionDuration)
            .attr('d', elbow);

        link.exit()
            .attr('d', function () {
                var o = {
                    x: source.x,
                    y: source.y
                };
                return elbow({
                    source: o,
                    target: o
                });
            })
            .remove();


        if (_options.phylogram && _options.alignPhylogram && _options.showExternalLabels
            && ( _options.showNodeName || _options.showTaxonomy || _options.showSequence )) {
            var linkExtension = _svgGroup.append("g")
                .selectAll('path')
                .data(links.filter(function (d) {
                    return (!d.target.children
                        && !( _options.dynahide && d.target.hide)
                    );
                }));

            linkExtension.enter().insert('path', 'g')
                .attr('class', "link")
                .attr('fill', "none")
                .attr('stroke-width', 1)
                .attr('stroke', _options.branchColorDefault)
                .style('stroke-opacity', 0.25)
                .attr('d', function (d) {
                    return connection(d.target);
                });
        }

        nodes.forEach(function (d) {
            d.x0 = d.x;
            d.y0 = d.y;
        });
    }

    var makeNodeSize = function (node) {

        if ((_options.showNodeEvents && node.events && node.children
            && ( node.events.duplications
            || node.events.speciations))
            || isNodeFound(node)) {
            return _options.nodeSizeDefault;
        }

        return (
            ( _options.nodeSizeDefault > 0 && node.parent && !( _options.showNodeVisualizations && node.hasVis) )
            && ( ( node.children && _options.showInternalNodes )
                || ( ( !node._children && !node.children ) && _options.showExternalNodes )
            )
            || ( _options.phylogram && node.parent && !node.parent.parent && (!node.branch_length || node.branch_length <= 0))

        ) ? makeVisNodeSize(node, 0.05) : 0;
    };

    var makeBranchWidth = function (link) {
        if (link.target.width) {
            return link.target.width;
        }
        return _options.branchWidthDefault;
    };

    var makeBranchColor = function (link) {
        if (link.target.color) {
            var c = link.target.color;
            return "rgb(" + c.red + "," + c.green + "," + c.blue + ")";
        }
        return _options.branchColorDefault;
    };

    function makeNodeEventsDependentColor(ev) {
        if (ev.duplications > 0 && ( !ev.speciations || ev.speciations <= 0 )) {
            return DUPLICATION_COLOR;
        }
        else if (ev.speciations > 0 && ( !ev.duplications || ev.duplications <= 0 )) {
            return SPECIATION_COLOR;
        }
        else if (ev.speciations > 0 && ev.duplications > 0) {
            return DUPLICATION_AND_SPECIATION_COLOR_COLOR;
        }
        return null;
    }


    var makeNodeFillColor = function (phynode) {
        var foundColor = getFoundColor(phynode);
        if (foundColor !== null) {
            return foundColor;
        }
        if (_options.showNodeEvents && phynode.events && phynode.children
            && (phynode.events.speciations || phynode.events.duplications )) {
            var evColor = makeNodeEventsDependentColor(phynode.events);
            if (evColor !== null) {
                return evColor;
            }
            else {
                return _options.backgroundColorDefault;
            }
        }
        return makeVisNodeFillColor(phynode);
    };

    var makeNodeStrokeColor = function (phynode) {
        var foundColor = getFoundColor(phynode);
        if (foundColor !== null) {
            return foundColor;
        }
        if (_options.showNodeEvents && phynode.events && phynode.children) {
            var evColor = makeNodeEventsDependentColor(phynode.events);
            if (evColor !== null) {
                return evColor;
            }
        }
        else if (_options.showNodeVisualizations) {
            return makeVisNodeBorderColor(phynode);
        }
        else if (phynode.color) {
            var c = phynode.color;
            return "rgb(" + c.red + "," + c.green + "," + c.blue + ")";
        }
        return _options.branchColorDefault;
    };

    var makeCollapsedColor = function (node) {
        var c = calcCollapsedColorInSubtree(node);
        if (c) {
            return c;
        }
        c = makeLabelColorForCollapsed(node);
        if (c) {
            return c;
        }
        if (node.color) {
            return "rgb(" + node.color.red + "," + node.color.green + "," + node.color.blue + ")";
        }
        return _options.branchColorDefault;
    };

    var makeLabelColor = function (phynode) {
        var foundColor = getFoundColor(phynode);
        if (foundColor !== null) {
            return foundColor;
        }
        if (_currentLabelColorVisualization) {
            var color = makeVisLabelColor(phynode);
            if (color) {
                return color;
            }
        }
        if (phynode.color) {
            var c = phynode.color;
            return "rgb(" + c.red + "," + c.green + "," + c.blue + ")";
        }
        return _options.labelColorDefault;
    };

    var makeLabelColorForCollapsed = function (phynode, color) {
        if (color && color != _options.branchColorDefault) {
            return color
        }
        if (_currentLabelColorVisualization) {
            var color = makeVisLabelColorForSubtree(phynode);
            if (color) {
                return color;
            }
        }
        if (phynode.color) {
            var c = phynode.color;
            return "rgb(" + c.red + "," + c.green + "," + c.blue + ")";
        }
        return _options.labelColorDefault;
    };

    var makeNodeVisShape = function (node) {
        if (_currentNodeShapeVisualization && _visualizations && !node._children && _visualizations.nodeShape
            && _visualizations.nodeShape[_currentNodeShapeVisualization] && !isNodeFound(node)
            && !(_options.showNodeEvents && ( node.events && (node.events.duplications
            || node.events.speciations)))) {
            var vis = _visualizations.nodeShape[_currentNodeShapeVisualization];
            if (vis.field) {
                var fieldValue = node[vis.field];
                if (fieldValue) {
                    if (vis.isRegex) {
                        for (var key in vis.mapping) {
                            if (vis.mapping.hasOwnProperty(key)) {
                                var re = new RegExp(key);
                                if (re && fieldValue.search(re) > -1) {
                                    return produceVis(vis, key);
                                }
                            }
                        }
                    }
                    else {
                        return produceVis(vis, fieldValue);
                    }
                }
            }
            else if (vis.cladePropertyRef && node.properties && node.properties.length > 0) {
                var ref_name = vis.cladePropertyRef;
                var propertiesLength = node.properties.length;
                for (var i = 0; i < propertiesLength; ++i) {
                    var p = node.properties[i];
                    if (p.value && p.ref === ref_name) {
                        return produceVis(vis, p.value);
                    }
                }
            }
        }

        return null;

        function produceVis(vis, key) {
            if (vis.mappingFn) {
                if (vis.mappingFn(key)) {
                    return makeShape(node, vis.mappingFn(key));
                }
            }
            else if (vis.mapping[key]) {
                return makeShape(node, vis.mapping[key]);
            }
            return null;
        }

        function makeShape(node, shape) {
            node.hasVis = true;
            return d3.svg.symbol().type(shape).size(makeVisNodeSize(node))();
        }
    };

    var makeVisNodeFillColor = function (node) {
        if (_options.showNodeVisualizations && _currentNodeFillColorVisualization && _visualizations && !node._children && _visualizations.nodeFillColor
            && _visualizations.nodeFillColor[_currentNodeFillColorVisualization]) {
            var vis = _visualizations.nodeFillColor[_currentNodeFillColorVisualization];
            var color = makeVisColor(node, vis);
            if (color) {
                return color;
            }
        }
        return _options.backgroundColorDefault;
    };

    var makeVisColor = function (node, vis) {
        if (vis.field) {
            var fieldValue = node[vis.field];
            if (fieldValue) {
                if (vis.isRegex) {
                    for (var key in vis.mapping) {
                        if (vis.mapping.hasOwnProperty(key)) {
                            var re = new RegExp(key);
                            if (re && fieldValue.search(re) > -1) {
                                return produceVis(vis, key);
                            }
                        }
                    }
                }
                else {
                    return produceVis(vis, fieldValue);
                }
            }
        }
        else if (vis.cladePropertyRef && node.properties && node.properties.length > 0) {
            var ref_name = vis.cladePropertyRef;
            var propertiesLength = node.properties.length;
            for (var i = 0; i < propertiesLength; ++i) {
                var p = node.properties[i];
                if (p.value && p.ref === ref_name) {
                    return produceVis(vis, p.value);
                }
            }
        }
        return null;

        function produceVis(vis, key) {
            return vis.mappingFn ? vis.mappingFn(key) : vis.mapping[key];
        }
    };

    function addLegend(type, vis) {
        if (vis) {
            _legendColorScales[type] = vis.mappingFn ? vis.mappingFn : null;
        }
    }

    function addLegendForShapes(type, vis) {
        if (vis) {
            _legendShapeScales[type] = vis.mappingFn ? vis.mappingFn : null;
        }
    }

    function addLegendForSizes(type, vis) {
        if (vis) {
            _legendSizeScales[type] = vis.mappingFn ? vis.mappingFn : null;
        }
    }

    function removeLegend(type) {
        _legendColorScales[type] = null;
    }

    function removeLegendForShapes(type) {
        _legendShapeScales[type] = null;
    }

    function removeLegendForSizes(type) {
        _legendSizeScales[type] = null;
    }

    var makeVisNodeBorderColor = function (node) {
        if (_options.showNodeVisualizations) {
            if (!_currentNodeBorderColorVisualization) {
                return _options.branchColorDefault;
            }
            if (_currentNodeBorderColorVisualization === SAME_AS_FILL) {
                return makeVisNodeFillColor(node);
            }
            if (_currentNodeBorderColorVisualization === NONE) {
                return _options.backgroundColorDefault;
            }
            if (_visualizations && !node._children && _visualizations.nodeBorderColor
                && _visualizations.nodeBorderColor[_currentNodeBorderColorVisualization]) {
                var vis = _visualizations.nodeBorderColor[_currentNodeBorderColorVisualization];
                var color = makeVisColor(node, vis);
                if (color) {
                    return color;
                }
            }
        }
        return _options.branchColorDefault;
    };

    var makeVisLabelColor = function (node) {
        if (_currentLabelColorVisualization && _visualizations && !node._children && _visualizations.labelColor
            && _visualizations.labelColor[_currentLabelColorVisualization]) {
            var vis = _visualizations.labelColor[_currentLabelColorVisualization];
            var color = makeVisColor(node, vis);
            if (color) {
                return color;
            }
        }
        return _options.labelColorDefault;
    };

    var makeVisLabelColorForSubtree = function (node) {
        var color = null;
        var success = true;
        if (_currentLabelColorVisualization && _visualizations && _visualizations.labelColor
            && _visualizations.labelColor[_currentLabelColorVisualization]) {
            var vis = _visualizations.labelColor[_currentLabelColorVisualization];
            forester.preOrderTraversalAll(node, function (n) {
                if (forester.isHasNodeData(n)) {
                    var c = makeVisColor(n, vis);
                    if (!c) {
                        success = false;
                    }
                    else if (color == null) {
                        color = c;
                    }
                    else if (color != c) {
                        success = false;
                    }
                }
            });
        }
        if (success === false) {
            return null;
        }
        return color;
    };


    var makeVisNodeSize = function (node, correctionFactor) {
        if (_options.showNodeVisualizations && _currentNodeSizeVisualization) {
            if (_visualizations && !node._children && _visualizations.nodeSize
                && _visualizations.nodeSize[_currentNodeSizeVisualization]) {
                var vis = _visualizations.nodeSize[_currentNodeSizeVisualization];
                var size;
                if (vis.field) {
                    var fieldValue = node[vis.field];
                    if (fieldValue) {
                        if (vis.isRegex) {
                            for (var key in vis.mapping) {
                                if (vis.mapping.hasOwnProperty(key)) {
                                    var re = new RegExp(key);
                                    if (re && fieldValue.search(re) > -1) {
                                        size = produceVis(vis, key, correctionFactor);
                                        if (size) {
                                            return size;
                                        }
                                    }
                                }
                            }
                        }
                        else {
                            size = produceVis(vis, fieldValue, correctionFactor);
                            if (size) {
                                return size;
                            }
                        }
                    }
                }
                else if (vis.cladePropertyRef && node.properties && node.properties.length > 0) {
                    var ref_name = vis.cladePropertyRef;
                    var propertiesLength = node.properties.length;
                    for (var i = 0; i < propertiesLength; ++i) {
                        var p = node.properties[i];
                        if (p.ref === ref_name && p.value) {
                            size = produceVis(vis, p.value, correctionFactor);
                            if (size) {
                                return size;
                            }
                        }
                    }
                }
            }
        }
        if (correctionFactor) {
            return _options.nodeSizeDefault;
        }
        else {
            return 2 * _options.nodeSizeDefault * _options.nodeSizeDefault;
        }


        function produceVis(vis, key, correctionFactor) {
            var size;
            if (vis.mappingFn) {
                size = vis.mappingFn(key);
            }
            else {
                size = vis.mapping[key];
            }
            if (size) {
                if (correctionFactor) {
                    return correctionFactor * size * _options.nodeSizeDefault;
                }
                else {
                    return size * _options.nodeSizeDefault;
                }
            }
            return null;
        }
    };

    function calcCollapsedColorInSubtree(node) {
        var found0 = 0;
        var found1 = 0;
        var found0and1 = 0;
        var total = 0;
        if (_foundNodes0 && _foundNodes1) {
            forester.preOrderTraversalAll(node, function (n) {
                if (forester.isHasNodeData(n)) {
                    ++total;
                    if (_foundNodes0.has(n) && _foundNodes1.has(n)) {
                        ++found0and1;
                    }
                    else if (_foundNodes0.has(n)) {
                        ++found0;
                    }
                    else if (_foundNodes1.has(n)) {
                        ++found1;
                    }
                }
            });
        }
        _foundSum = found0and1 + found0 + found1;
        _totalSearchedWithData = total;

        if (total > 0 && _foundSum > 0) {
            if ((found0and1 > 0) || ((found0 > 0) && ( found1 > 0) )) {
                if (found0and1 === total) {
                    return _options.found0and1ColorDefault;
                }
                return d3.scale.linear()
                    .domain([0, total])
                    .range([_options.branchColorDefault, _options.found0and1ColorDefault])(_foundSum);
            }
            else if (found0 > 0) {
                if (found0 === total) {
                    return _options.found0ColorDefault;
                }
                return d3.scale.linear()
                    .domain([0, total])
                    .range([_options.branchColorDefault, _options.found0ColorDefault])(found0);
            }
            else if (found1 > 0) {
                if (found1 === total) {
                    return _options.found1ColorDefault;
                }
                return d3.scale.linear()
                    .domain([0, total])
                    .range([_options.branchColorDefault, _options.found1ColorDefault])(found1);
            }
        }
        return null;
    }


    function getFoundColor(phynode) {
        if (!_options.searchNegateResult) {
            if (_foundNodes0 && _foundNodes1 && _foundNodes0.has(phynode) && _foundNodes1.has(phynode)) {
                return _options.found0and1ColorDefault;
            }
            else if (_foundNodes0 && _foundNodes0.has(phynode)) {
                return _options.found0ColorDefault;
            }
            else if (_foundNodes1 && _foundNodes1.has(phynode)) {
                return _options.found1ColorDefault;
            }
        }
        else if (forester.isHasNodeData(phynode)) {
            if ((_foundNodes0 && !_searchBox0Empty) && (_foundNodes1 && !_searchBox1Empty) && !_foundNodes0.has(phynode) && !_foundNodes1.has(phynode)) {
                return _options.found0and1ColorDefault;
            }
            else if ((_foundNodes0 && !_searchBox0Empty) && !_foundNodes0.has(phynode)) {
                return _options.found0ColorDefault;
            }
            else if ((_foundNodes1 && !_searchBox1Empty) && !_foundNodes1.has(phynode)) {
                return _options.found1ColorDefault;
            }
        }
        return null;
    }

    function isNodeFound(phynode) {
        if (!_options.searchNegateResult) {
            if ((_foundNodes0 && _foundNodes0.has(phynode)) || (_foundNodes1 && _foundNodes1.has(phynode))) {
                return true;
            }
        }
        else if (forester.isHasNodeData(phynode)) {
            if (((_foundNodes0 && !_searchBox0Empty) && !_foundNodes0.has(phynode)) || ((_foundNodes1 && !_searchBox1Empty) && !_foundNodes1.has(phynode))) {
                return true
            }
        }
        return false;
    }

    var makeNodeLabel = function (phynode) {
        if (!_options.showExternalLabels && !( phynode.children || phynode._children)) {
            return null;
        }
        if (!_options.showInternalLabels && ( phynode.children || phynode._children)) {
            return null;
        }
        var l = "";
        if (_options.showNodeName) {
            l = append(l, phynode.name);
        }
        if (_options.showTaxonomy && phynode.taxonomies && phynode.taxonomies.length > 0) {
            var t = phynode.taxonomies[0];
            if (_options.showTaxonomyCode) {
                l = append(l, t.code);
            }
            if (_options.showTaxonomyScientificName) {
                l = append(l, t.scientific_name);
            }
            if (_options.showTaxonomyCommonName) {
                l = appendP(l, t.common_name);
            }
            if (_options.showTaxonomyRank) {
                l = appendP(l, t.rank);
            }
            if (_options.showTaxonomySynonyms) {
                if (t.synonyms && t.synonyms.length > 0) {
                    var syn = t.synonyms;
                    for (var i = 0; i < syn.length; ++i) {
                        l = appendB(l, syn[i]);
                    }
                }
            }
        }
        if (_options.showSequence && phynode.sequences && phynode.sequences.length > 0) {
            var s = phynode.sequences[0];
            if (_options.showSequenceSymbol) {
                l = append(l, s.symbol);
            }
            if (_options.showSequenceName) {
                l = append(l, s.name);
            }
            if (_options.showSequenceGeneSymbol) {
                l = appendP(l, s.gene_name);
            }
            if (_options.showSequenceAccession && s.accession && s.accession.value) {
                l = appendP(l, s.accession.value);
            }
        }
        if (_options.showDistributions && phynode.distributions && phynode.distributions.length > 0) {
            var d = phynode.distributions;
            for (var ii = 0; i < d.length; ++ii) {
                l = appendB(l, d[ii].desc);
            }
        }
        return l;

        function append(str1, str2) {
            if (str2 && str2.length > 0) {
                if (str1.length > 0) {
                    str1 += ( " " + str2 );
                }
                else {
                    str1 = str2;
                }
            }
            return str1;
        }

        function appendP(str1, str2) {
            if (str2 && str2.length > 0) {
                if (str1.length > 0) {
                    str1 += ( " (" + str2 + ")");
                }
                else {
                    str1 = "(" + str2 + ")";
                }
            }
            return str1;
        }

        function appendB(str1, str2) {
            if (str2 && str2.length > 0) {
                if (str1.length > 0) {
                    str1 += ( " [" + str2 + "]");
                }
                else {
                    str1 = "[" + str2 + "]";
                }
            }
            return str1;
        }
    };


    var makeCollapsedLabel = function (node, descs) {
        if (node.hide) {
            return;
        }

        var first;
        var last;
        if (descs.length > 1) {
            first = descs[0];
            last = descs[descs.length - 1];
        }
        var text = null;
        if (first && last) {
            var first_label = makeNodeLabel(first);
            var last_label = makeNodeLabel(last);

            if (first_label && last_label) {
                text = first_label.substring(0, _options.collapsedLabelLength)
                    + " ... " + last_label.substring(0, _options.collapsedLabelLength)
                    + " [" + descs.length + "]";
                if (_foundSum > 0 && _totalSearchedWithData) {
                    text += (' [' + _foundSum + '/' + _totalSearchedWithData + ']' );
                }
            }

            if (node[KEY_FOR_COLLAPSED_FEATURES_SPECIAL_LABEL]) {
                if (text) {
                    text = node[KEY_FOR_COLLAPSED_FEATURES_SPECIAL_LABEL] + ': ' + text;
                }
                else {
                    text = node[KEY_FOR_COLLAPSED_FEATURES_SPECIAL_LABEL];
                }
            }
        }
        return text;
    };

    var makeBranchLengthLabel = function (phynode) {
        if (phynode.branch_length) {
            if (_options.phylogram
                && _options.minBranchLengthValueToShow
                && phynode.branch_length < _options.minBranchLengthValueToShow) {
                return;
            }
            return +phynode.branch_length.toFixed(BRANCH_LENGTH_DIGITS_DEFAULT);
        }
    };

    var makeConfidenceValuesLabel = function (phynode) {
        if (phynode.confidences && phynode.confidences.length > 0) {
            var c = phynode.confidences;
            var cl = c.length;
            if (_options.minConfidenceValueToShow) {
                var show = false;
                for (var i = 0; i < cl; ++i) {
                    if (c[i].value >= _options.minConfidenceValueToShow) {
                        show = true;
                        break;
                    }
                }
                if (!show) {
                    return;
                }
            }
            if (cl == 1) {
                if (c[0].value) {
                    return +c[0].value.toFixed(CONFIDENCE_VALUE_DIGITS_DEFAULT);
                }
            }
            else {
                var s = "";
                for (var ii = 0; ii < cl; ++ii) {
                    if (c[ii].value) {
                        if (ii > 0) {
                            s += "/";
                        }
                        s += +c[ii].value.toFixed(CONFIDENCE_VALUE_DIGITS_DEFAULT);
                    }
                }
                return s;
            }
        }
    };

    var makeBranchEventsLabel = function (phynode) {
        if (phynode.properties && phynode.properties.length > 0) {
            var l = phynode.properties.length;
            var str = null;
            for (var p = 0; p < l; ++p) {
                if (phynode.properties[p].ref === BRANCH_EVENT_REF
                    && phynode.properties[p].datatype === BRANCH_EVENT_DATATYPE
                    && phynode.properties[p].applies_to === BRANCH_EVENT_APPLIES_TO) {
                    if (str === null) {
                        str = phynode.properties[p].value;
                    }
                    else {
                        str += ( ' | ' + phynode.properties[p].value );
                    }
                }
            }
            if (str !== null) {
                return str;
            }
        }
    };

    var elbow = function (d) {
        return 'M' + d.source.y + ',' + d.source.x
            + 'V' + d.target.x + 'H' + d.target.y;
    };

    var connection = function (n) {
        if (_options.phylogram) {
            var x1 = n.y + 5;
            if (n._children) {
                x1 += n.avg;
            }
            var y = n.x;
            var x = (n.y - _yScale(n.distToRoot) + _w );
            if ((x - x1) > 5) {
                return 'M' + x1 + ',' + y
                    + 'L' + x + ',' + y;
            }
        }
    };


    function initializeOptions(options) {
        _options = options ? options : {};

        if (_basicTreeProperties.branchLengths) {
            if (_options.phylogram === undefined) {
                _options.phylogram = true;
            }
            if (_options.alignPhylogram === undefined) {
                _options.alignPhylogram = false;
            }
        }
        else {
            _options.phylogram = false;
            _options.alignPhylogram = false;
        }
        if (_options.phylogram === false) {
            _options.alignPhylogram = false;
        }
        if (_options.dynahide === undefined) {
            _options.dynahide = true;
        }
        if (_options.showBranchLengthValues === undefined) {
            _options.showBranchLengthValues = false;
        }
        if (_options.showConfidenceValues === undefined) {
            _options.showConfidenceValues = false;
        }
        if (_options.showNodeName === undefined) {
            _options.showNodeName = true;
        }
        if (_options.showTaxonomy === undefined) {
            _options.showTaxonomy = false;
        }
        if (_options.showTaxonomyCode === undefined) {
            _options.showTaxonomyCode = true;
        }
        if (_options.showTaxonomyScientificName === undefined) {
            _options.showTaxonomyScientificName = true;
        }
        if (_options.showTaxonomyCommonName === undefined) {
            _options.showTaxonomyCommonName = false;
        }
        if (_options.showTaxonomyRank === undefined) {
            _options.showTaxonomyRank = false;
        }
        if (_options.showTaxonomySynonyms === undefined) {
            _options.showTaxonomySynonyms = false;
        }
        if (_options.showSequence === undefined) {
            _options.showSequence = false;
        }
        if (_options.showSequenceSymbol === undefined) {
            _options.showSequenceSymbol = true;
        }
        if (_options.showSequenceName === undefined) {
            _options.showSequenceName = true;
        }
        if (_options.showSequenceGeneSymbol === undefined) {
            _options.showSequenceGeneSymbol = false;
        }
        if (_options.showSequenceAccession === undefined) {
            _options.showSequenceAccession = false;
        }
        if (_options.showDistributions === undefined) {
            _options.showDistributions = false;
        }
        if (_options.showInternalNodes === undefined) {
            _options.showInternalNodes = false;
        }
        if (_options.showExternalNodes === undefined) {
            _options.showExternalNodes = false;
        }
        if (_options.showInternalLabels === undefined) {
            _options.showInternalLabels = false;
        }
        if (_options.showExternalLabels === undefined) {
            _options.showExternalLabels = true;
        }
        if (!_options.branchWidthDefault) {
            _options.branchWidthDefault = 1;
        }
        if (!_options.branchColorDefault) {
            _options.branchColorDefault = "#aaaaaa";
        }
        if (!_options.labelColorDefault) {
            _options.labelColorDefault = "#202020";
        }
        if (!_options.backgroundColorDefault) {
            _options.backgroundColorDefault = "#f0f0f0";
        }
        if (!_options.found0ColorDefault) {
            _options.found0ColorDefault = "#66cc00";
        }
        if (!_options.found1ColorDefault) {
            _options.found1ColorDefault = "#ff00ff";
        }
        if (!_options.found0and1ColorDefault) {
            _options.found0and1ColorDefault = "#0000ee";
        }
        if (!_options.defaultFont) {
            _options.defaultFont = ['Arial', 'Helvetica', 'Tahoma', 'Geneva', 'Verdana', 'Sans-Serif'];
        }
        if (!_options.nodeSizeDefault) {
            _options.nodeSizeDefault = 3;
        }
        if (!_options.externalNodeFontSize) {
            _options.externalNodeFontSize = 10;
        }
        if (!_options.internalNodeFontSize) {
            _options.internalNodeFontSize = 9;
        }
        if (!_options.branchDataFontSize) {
            _options.branchDataFontSize = 7;
        }
        if (!_options.collapsedLabelLength) {
            _options.collapsedLabelLength = 7;
        }
        if (!_options.nodeLabelGap) {
            _options.nodeLabelGap = 10;
        }
        if (!_options.minBranchLengthValueToShow) {
            _options.minBranchLengthValueToShow = null;
        }
        if (_options.minConfidenceValueToShow === undefined) {
            _options.minConfidenceValueToShow = null;
        }
        if (_options.searchIsCaseSensitive === undefined) {
            _options.searchIsCaseSensitive = false;
        }
        if (_options.searchIsPartial === undefined) {
            _options.searchIsPartial = true;
        }
        _options.searchNegateResult = false;
        if (_options.searchUsesRegex === undefined) {
            _options.searchUsesRegex = false;
        }
        if (_options.alignPhylogram === undefined) {
            _options.alignPhylogram = false;
        }
        if (_options.showNodeEvents === undefined) {
            _options.showNodeEvents = false;
        }
        if (_options.showBranchEvents === undefined) {
            _options.showBranchEvents = false;
        }
        if (_options.showNodeVisualizations === undefined) {
            _options.showNodeVisualizations = false;
        }
        if (_options.showBranchVisualizations === undefined) {
            _options.showBranchVisualizations = false;
        }
        if (_options.nodeVisualizationsOpacity === undefined) {
            _options.nodeVisualizationsOpacity = 1;
        }
        if (!_options.nameForNhDownload) {
            _options.nameForNhDownload = NAME_FOR_NH_DOWNLOAD_DEFAULT;
        }
        if (!_options.nameForPhyloXmlDownload) {
            _options.nameForPhyloXmlDownload = NAME_FOR_PHYLOXML_DOWNLOAD_DEFAULT;
        }
        if (!_options.nameForPngDownload) {
            _options.nameForPngDownload = NAME_FOR_PNG_DOWNLOAD_DEFAULT;
        }
        if (!_options.nameForSvgDownload) {
            _options.nameForSvgDownload = NAME_FOR_SVG_DOWNLOAD_DEFAULT;
        }
        if (!_options.visualizationsLegendXpos) {
            _options.visualizationsLegendXpos = VISUALIZATIONS_LEGEND_XPOS_DEFAULT;
        }
        if (!_options.visualizationsLegendYpos) {
            _options.visualizationsLegendYpos = VISUALIZATIONS_LEGEND_YPOS_DEFAULT;
        }
        _options.visualizationsLegendXposOrig = _options.visualizationsLegendXpos;
        _options.visualizationsLegendYposOrig = _options.visualizationsLegendYpos;
        if (!_options.visualizationsLegendOrientation) {
            _options.visualizationsLegendOrientation = VISUALIZATIONS_LEGEND_ORIENTATION_DEFAULT;
        }
        if (!_options.showVisualizationsLegend === undefined) {
            _options.showVisualizationsLegend = true;
        }
        _options.externalNodeFontSize = parseInt(_options.externalNodeFontSize);
        _options.internalNodeFontSize = parseInt(_options.internalNodeFontSize);
        _options.branchDataFontSize = parseInt(_options.branchDataFontSize);


    }

    function initializeSettings(settings) {
        _settings = settings ? settings : {};
        if (!_settings.rootOffset) {
            _settings.rootOffset = ROOTOFFSET_DEFAULT;
        }
        if (!_settings.displayWidth) {
            _settings.displayWidth = DISPLAY_WIDTH_DEFAULT;
        }
        if (!_settings.displayHeight) {
            _settings.displayHeight = VIEWERHEIGHT_DEFAULT;
        }
        if (!_settings.reCenterAfterCollapse) {
            _settings.reCenterAfterCollapse = RECENTER_AFTER_COLLAPSE_DEFAULT;
        }
        if (!_settings.controlsFontSize) {
            _settings.controlsFontSize = CONTROLS_FONT_SIZE_DEFAULT;
        }
        if (!_settings.controlsFontColor) {
            _settings.controlsFontColor = CONTROLS_FONT_COLOR_DEFAULT;
        }
        if (!_settings.controlsFont) {
            _settings.controlsFont = CONTROLS_FONT_DEFAULTS;
        }
        if (!_settings.controlsBackgroundColor) {
            _settings.controlsBackgroundColor = CONTROLS_BACKGROUND_COLOR_DEFAULT;
        }
        if (!_settings.controls0) {
            _settings.controls0 = CONTROLS_0;
        }
        if (!_settings.controls0Left) {
            _settings.controls0Left = CONTROLS_0_LEFT_DEFAULT;
        }
        if (!_settings.controls0Top) {
            _settings.controls0Top = CONTROLS_0_TOP_DEFAULT;
        }
        if (!_settings.controls1Top) {
            _settings.controls1Top = CONTROLS_1_TOP_DEFAULT;
        }
        if (!_settings.controls1) {
            _settings.controls1 = CONTROLS_1;
        }
        if (!_settings.controls1Left) {
            _settings.controls1Left = _settings.displayWidth - CONTROLS_1_WIDTH;
        }
        if (_settings.enableDownloads === undefined) {
            _settings.enableDownloads = false;
        }
        if (_settings.enableBranchVisualizations === undefined) {
            _settings.enableBranchVisualizations = false;
        }
        if (_settings.enableNodeVisualizations === undefined) {
            _settings.enableNodeVisualizations = false;
        }
        if (_settings.enableCollapseByBranchLenghts === undefined) {
            _settings.enableCollapseByBranchLenghts = false;
        }
        if (_settings.enableCollapseByTaxonomyRank === undefined) {
            _settings.enableCollapseByTaxonomyRank = false;
        }
        if (_settings.enableCollapseByFeature === undefined) {
            _settings.enableCollapseByFeature = false;
        }
        if (_settings.nhExportWriteConfidences === undefined) {
            _settings.nhExportWriteConfidences = false;
        }
        if (_settings.showDynahideButton === undefined) {
            _settings.showDynahideButton = false;
        }
        if (_settings.nhExportReplaceIllegalChars === undefined) {
            _settings.nhExportReplaceIllegalChars = true;
        }


        _settings.controlsFontSize = parseInt(_settings.controlsFontSize);

        intitializeDisplaySize();
    }

    function intitializeDisplaySize() {
        _displayHeight = _settings.displayHeight;
        _displayWidth = _settings.displayWidth;
    }

    function mouseDown() {
        if (d3.event.which === 1 && ( d3.event.altKey || d3.event.shiftKey )) {
            if ((_showLegends && ( _settings.enableNodeVisualizations || _settings.enableBranchVisualizations ) && ( _legendColorScales[LEGEND_LABEL_COLOR] ||
                (_options.showNodeVisualizations && ( _legendColorScales[LEGEND_NODE_FILL_COLOR] ||
                _legendColorScales[LEGEND_NODE_BORDER_COLOR] ||
                _legendShapeScales[LEGEND_NODE_SHAPE] ||
                _legendSizeScales[LEGEND_NODE_SIZE]))))) {
                moveLegendWithMouse(d3.event);
            }
        }
    }

    archaeopteryx.launch = function (id, phylo, options, settings, nodeVisualizations) {


        _treeData = phylo;

        _zoomListener = d3.behavior.zoom().scaleExtent([0.1, 10]).on('zoom', zoom);
        _basicTreeProperties = forester.collectBasicTreeProperties(_treeData);

        if (nodeVisualizations) {
            _nodeVisualizations = nodeVisualizations;
        }

        if (settings.readSimpleCharacteristics) {
            forester.moveSimpleCharacteristicsToProperties(_treeData);
        }

        initializeOptions(options);
        initializeSettings(settings);

        if (settings.enableNodeVisualizations) {
            var np = forester.collectProperties(_treeData, 'node', false);
            initializeNodeVisualizations(np);
        }
        _id = id;

        createGui(_basicTreeProperties);

        if (settings.enableNodeVisualizations || settings.enableBranchVisualizations) {
            d3.select(window)
                .on("mousedown", mouseDown);
        }

        _baseSvg = d3.select(id).append('svg')
            .attr('width', _displayWidth)
            .attr('height', _displayHeight)
            .attr('class', OVERLAY)
            .style('background-color', _options.backgroundColorDefault)
            .style('border', function () {
                if (_settings.border) {
                    return _settings.border;
                }
                else {
                    return '';
                }
            })
            .call(_zoomListener);

        _svgGroup = _baseSvg.append('g');

        _treeFn = d3.layout.cluster()
            .size([_displayHeight, _displayWidth]);

        _treeFn.clickEvent = getClickEventListenerNode(phylo);

        _root = phylo;

        calcMaxExtLabel();

        _root.x0 = _displayHeight / 2;
        _root.y0 = 0;

        initializeGui();

        update(null, 0);

        centerNode(_root, _settings.rootOffset);
    };

    archaeopteryx.parsePhyloXML = function (data) {
        return phyloXml.parse(data, {trim: true, normalize: true})[0]
    };

    archaeopteryx.parseNewHampshire = function (data, confidenceValuesInBrackets, confidenceValuesAsInternalNames) {
        return forester.parseNewHampshire(data, confidenceValuesInBrackets, confidenceValuesAsInternalNames);
    };

    function calcMaxExtLabel() {
        _maxLabelLength = _options.nodeLabelGap;
        forester.preOrderTraversal(_root, function (d) {
            if (d._children) {
                _maxLabelLength = Math.max((2 * _options.collapsedLabelLength) + 8, _maxLabelLength);
            }
            else if (!d.children) {
                var l = makeNodeLabel(d);
                if (l) {
                    _maxLabelLength = Math.max(l.length, _maxLabelLength);
                }
            }
        });
    }


    function removeTooltips() {
        _svgGroup.selectAll('.tooltipElem').remove();
    }


    function getClickEventListenerNode(tree) {

        function nodeClick() {

            if (_showColorPicker === true) {
                removeColorPicker();
                update();
            }
            function displayNodeData(n) {
                var title = n.name ? 'Node Data: ' + n.name : 'Node Data';
                var text = '';
                if (n.name) {
                    text += 'Name: ' + n.name + '<br>';
                }
                if (n.branch_length) {
                    text += 'Distance to Parent: ' + n.branch_length + '<br>';
                }
                var i = 0;
                if (n.confidences) {
                    for (i = 0; i < n.confidences.length; ++i) {
                        var c = n.confidences[i];
                        if (c.type) {
                            text += 'Confidence [' + c.type + ']: ' + c.value + '<br>';
                        }
                        else {
                            text += 'Confidence: ' + c.value + '<br>';
                        }
                        if (c.stddev) {
                            text += '- stdev: ' + c.stddev + '<br>';
                        }
                    }
                }
                if (n.taxonomies) {
                    for (i = 0; i < n.taxonomies.length; ++i) {
                        text += 'Taxonomy<br>';
                        var t = n.taxonomies[i];
                        if (t.id) {
                            if (t.id.provider) {
                                text += '- Id [' + t.id.provider + ']: ' + t.id.value + '<br>';
                            }
                            else {
                                text += '- Id: ' + t.id.value + '<br>';
                            }
                        }
                        if (t.code) {
                            text += '- Code: ' + t.code + '<br>';
                        }
                        if (t.scientific_name) {
                            text += '- Scientific name: ' + t.scientific_name + '<br>';
                        }
                        if (t.common_name) {
                            text += '- Common name: ' + t.common_name + '<br>';
                        }
                        if (t.rank) {
                            text += '- Rank: ' + t.rank + '<br>';
                        }
                    }
                }
                if (n.sequences) {
                    for (i = 0; i < n.sequences.length; ++i) {
                        text += 'Sequence<br>';
                        var s = n.sequences[i];
                        if (s.accession) {
                            if (s.accession.source) {
                                text += '- Accession [' + s.accession.source + ']: ' + s.accession.value + '<br>';
                            }
                            else {
                                text += '- Accession: ' + s.accession.value + '<br>';
                            }
                            if (s.accession.comment) {
                                text += '-- comment: ' + s.accession.comment + '<br>';
                            }
                        }
                        if (s.symbol) {
                            text += '- Symbol: ' + s.symbol + '<br>';
                        }
                        if (s.name) {
                            text += '- Name: ' + s.name + '<br>';
                        }
                        if (s.gene_name) {
                            text += '- Gene name: ' + s.gene_name + '<br>';
                        }
                        if (s.location) {
                            text += '- Location: ' + s.location + '<br>';
                        }
                        if (s.type) {
                            text += '- Type: ' + s.type + '<br>';
                        }
                    }
                }
                if (n.distributions) {
                    var distributions = n.distributions;
                    for (i = 0; i < distributions.length; ++i) {
                        text += 'Distribution: ';
                        if (distributions[i].desc) {
                            text += distributions[i].desc + '<br>';
                        }
                    }
                }
                if (n.date) {
                    text += 'Date: ';
                    var date = n.date;
                    if (date.desc) {
                        text += date.desc + '<br>';
                    }
                }
                if (n.events) {
                    text += 'Events<br>';
                    var ev = n.events;
                    if (ev.type && ev.type.length > 0) {
                        text += '- Type: ' + ev.type + '<br>';
                    }
                    if (ev.duplications && ev.duplications > 0) {
                        text += '- Duplications: ' + ev.duplications + '<br>';
                    }
                    if (ev.speciations && ev.speciations > 0) {
                        text += '- Speciations: ' + ev.speciations + '<br>';
                    }
                    if (ev.losses && ev.losses > 0) {
                        text += '- Losses: ' + ev.losses + '<br>';
                    }
                }
                if (n.properties && n.properties.length > 0) {
                    var propertiesLength = n.properties.length;
                    for (i = 0; i < propertiesLength; ++i) {
                        var property = n.properties[i];
                        if (property.ref && property.value) {
                            if (property.unit) {
                                text += property.ref + ': ' + property.value + property.unit + '<br>';
                            }
                            else {
                                text += property.ref + ': ' + property.value + '<br>';
                            }
                        }
                    }
                }
                if (n.children || n._children) {
                    text += 'Number of External Nodes: ' + forester.calcSumOfAllExternalDescendants(n) + '<br>';
                }
                text += 'Depth: ' + forester.calcDepth(n) + '<br>';

                var nodeData = document.getElementById(NODE_DATA);
                if (nodeData && nodeData.outerHTML) {
                    nodeData.outerHTML = '';
                }

                $("<div id='" + NODE_DATA + "'>" + text + "</div>").dialog();
                var dialog = $('#' + NODE_DATA);

                var fs = _settings.controlsFontSize.toString() + 'px';

                $('.ui-dialog').css({
                    'text-align': 'left',
                    'color': _settings.controlsFontColor,
                    'font-size': fs,
                    'font-family': _settings.controlsFont,
                    'font-style': 'normal',
                    'font-weight': 'normal',
                    'text-decoration': 'none'
                });

                $('.ui-dialog-titlebar').css({
                    'text-align': 'left',
                    'color': _settings.controlsFontColor,
                    'font-size': fs,
                    'font-family': _settings.controlsFont,
                    'font-style': 'normal',
                    'font-weight': 'bold',
                    'text-decoration': 'none'
                });

                dialog.dialog('option', 'modal', true);
                dialog.dialog('option', 'title', title);

                update();
            }

            function goToSubTree(node) {
                if (node.parent && ( node.children || node._children )) {
                    if (_superTreeRoots.length > 0 && node === _root.children[0]) {
                        _root = _superTreeRoots.pop();
                        resetDepthCollapseDepthValue();
                        resetRankCollapseRankValue();
                        resetBranchLengthCollapseValue();
                        zoomFit();
                    }
                    else if (node.parent.parent) {
                        _superTreeRoots.push(_root);
                        var fakeNode = {};
                        fakeNode.children = [node];
                        fakeNode.x = 0;
                        fakeNode.x0 = 0;
                        fakeNode.y = 0;
                        fakeNode.y0 = 0;
                        _root = fakeNode;
                        if (node._children) {
                            // To make sure, new root is uncollapsed.
                            node.children = node._children;
                            node._children = null;
                        }
                        resetDepthCollapseDepthValue();
                        resetRankCollapseRankValue();
                        resetBranchLengthCollapseValue();
                        zoomFit();
                    }
                }
            }

            function swapChildren(d) {
                var c = d.children;
                var l = c.length;
                if (l > 1) {
                    var first = c[0];
                    for (var i = 0; i < l - 1; ++i) {
                        c[i] = c[i + 1];
                    }
                    c[l - 1] = first;
                }
            }

            function toggleCollapse(node) {
                if (node.children) {
                    node._children = node.children;
                    node.children = null;
                }
                else {
                    unCollapseAll(node);
                }
            }


            var rectWidth = 120;
            var rectHeight = 150;

            removeTooltips();

            d3.select(this).append('rect')
                .attr('class', 'tooltipElem')
                .attr('x', 0)
                .attr('y', 0)
                .attr('width', rectWidth)
                .attr('height', rectHeight)
                .attr('rx', 10)
                .attr('ry', 10)
                .style('fill-opacity', 0.9)
                .style('fill', NODE_TOOLTIP_BACKGROUND_COLOR);

            var rightPad = 10;
            var topPad = 20;
            var textSum = 0;
            var textInc = 20;

            var fs = _settings.controlsFontSize.toString() + 'px';

            d3.select(this).append('text')
                .attr('class', 'tooltipElem tooltipElemText')
                .attr('y', topPad + textSum)
                .attr('x', +rightPad)
                .style('text-align', 'left')
                .style('fill', NODE_TOOLTIP_TEXT_COLOR)
                .style('font-size', fs)
                .style('font-family', 'Helvetica')
                .style('font-style', 'normal')
                .style('font-weight', 'bold')
                .style('text-decoration', 'none')
                .text(function (d) {
                    if (d.parent) {
                        textSum += textInc;
                        return 'Display Node Data';
                    }
                })
                .on('click', function (d) {
                    displayNodeData(d);
                });

            d3.select(this).append('text')
                .attr('class', 'tooltipElem tooltipElemText')
                .attr('y', topPad + textSum)
                .attr('x', +rightPad)
                .style('text-align', 'left')
                .style('fill', NODE_TOOLTIP_TEXT_COLOR)
                .style('font-size', fs)
                .style('font-family', _settings.controlsFont)
                .style('font-style', 'normal')
                .style('font-weight', 'bold')
                .style('text-decoration', 'none')
                .text(function (d) {
                    if (d.parent && d.parent.parent) {
                        if (d._children) {
                            textSum += textInc;
                            return 'Uncollapse';
                        }
                        else if (d.children) {
                            textSum += textInc;
                            return 'Collapse';
                        }
                    }
                })
                .on('click', function (d) {
                    toggleCollapse(d);
                    resetDepthCollapseDepthValue();
                    resetRankCollapseRankValue();
                    resetBranchLengthCollapseValue();
                    resetCollapseByFeature();
                    update(d);
                });

            d3.select(this).append('text')
                .attr('class', 'tooltipElem tooltipElemText')
                .attr('y', topPad + textSum)
                .attr('x', +rightPad)
                .style('text-align', 'left')
                .style('fill', NODE_TOOLTIP_TEXT_COLOR)
                .style('font-size', fs)
                .style('font-family', _settings.controlsFont)
                .style('font-style', 'normal')
                .style('font-weight', 'bold')
                .style('text-decoration', 'none')
                .text(function (d) {
                    var cc = 0;
                    forester.preOrderTraversalAll(d, function (e) {
                        if (e._children) {
                            ++cc;
                        }
                    });
                    if (cc > 1 || ( cc == 1 && !d._children )) {
                        textSum += textInc;
                        return 'Uncollapse All';
                    }
                })
                .on('click', function (d) {
                    unCollapseAll(d);
                    resetDepthCollapseDepthValue();
                    resetRankCollapseRankValue();
                    resetBranchLengthCollapseValue();
                    resetCollapseByFeature();
                    update();
                });

            d3.select(this).append('text')
                .attr('class', 'tooltipElem tooltipElemText')
                .attr('y', topPad + textSum)
                .attr('x', +rightPad)
                .style('text-align', 'left')
                .style('fill', NODE_TOOLTIP_TEXT_COLOR)
                .style('font-size', fs)
                .style('font-family', _settings.controlsFont)
                .style('font-style', 'normal')
                .style('font-weight', 'bold')
                .style('text-decoration', 'none')
                .text(function (d) {
                    if (d.parent && ( d.children || d._children )) {
                        if (_superTreeRoots.length > 0 && d === _root.children[0]) {
                            textSum += textInc;
                            return 'Return to Super-tree';
                        }
                        else if (d.parent.parent) {
                            textSum += textInc;
                            return 'Go to Sub-tree';
                        }
                    }

                })
                .on('click', function (d) {
                    goToSubTree(d);
                });

            d3.select(this).append('text')
                .attr('class', 'tooltipElem tooltipElemText')
                .attr('y', topPad + textSum)
                .attr('x', +rightPad)
                .style('text-align', 'left')
                .style('fill', NODE_TOOLTIP_TEXT_COLOR)
                .style('font-size', fs)
                .style('font-family', _settings.controlsFont)
                .style('font-style', 'normal')
                .style('font-weight', 'bold')
                .style('text-decoration', 'none')
                .text(function (d) {
                    if (d.parent) {
                        if (d.children) {
                            textSum += textInc;
                            return 'Swap Descendants';
                        }
                    }
                })
                .on('click', function (d) {
                    swapChildren(d);
                    update();
                });

            d3.select(this).append('text')
                .attr('class', 'tooltipElem tooltipElemText')
                .attr('y', topPad + textSum)
                .attr('x', +rightPad)
                .style('text-align', 'left')
                .style('fill', NODE_TOOLTIP_TEXT_COLOR)
                .style('font-size', fs)
                .style('font-family', _settings.controlsFont)
                .style('font-style', 'normal')
                .style('font-weight', 'bold')
                .style('text-decoration', 'none')
                .text(function (d) {
                    if (d.parent) {
                        if (d.children) {
                            textSum += textInc;
                            return 'Order Subtree';
                        }
                    }
                })
                .on('click', function (d) {
                    if (!_treeFn.visData) {
                        _treeFn.visData = {};
                    }
                    if (_treeFn.visData.order === undefined) {
                        _treeFn.visData.order = true;
                    }
                    orderSubtree(d, _treeFn.visData.order);
                    _treeFn.visData.order = !_treeFn.visData.order;
                    update(null, 0);
                });


            d3.select(this).append('text')
                .attr('class', 'tooltipElem tooltipElemText')
                .attr('y', topPad + textSum)
                .attr('x', +rightPad)
                .style('text-align', 'left')
                .style('align', 'left')
                .style('fill', NODE_TOOLTIP_TEXT_COLOR)
                .style('font-size', fs)
                .style('font-family', _settings.controlsFont)
                .style('font-style', 'normal')
                .style('font-weight', 'bold')
                .style('text-decoration', 'none')
                .text(function (d) {
                    if (d.parent && d.parent.parent && _superTreeRoots.length < 1) {
                        textSum += textInc;
                        return 'Reroot';
                    }
                })
                .on('click', function (d) {
                    forester.reRoot(tree, d, -1);
                    resetDepthCollapseDepthValue();
                    resetRankCollapseRankValue();
                    resetBranchLengthCollapseValue();
                    resetCollapseByFeature();
                    unCollapseAll(_root);
                    zoomFit();
                });

            d3.selection.prototype.moveToFront = function () {
                return this.each(function () {
                    this.parentNode.appendChild(this);
                });
            };
            d3.select(this).moveToFront();
            d3.select(this).selectAll('.tooltipElemText').each(function (d) {
                d3.select(this).on('mouseover', function (d) {
                    d3.select(this).transition().duration(50).style('fill', NODE_TOOLTIP_TEXT_ACTIVE_COLOR);
                });
                d3.select(this).on('mouseout', function (d) {
                    d3.select(this).transition().duration(50).style('fill', NODE_TOOLTIP_TEXT_COLOR);
                });
            });
        }

        return nodeClick;
    }


    $('html').click(function (d) {
        var attrClass = d.target.getAttribute('class');
        if (( attrClass !== 'nodeCircleOptions')) {
            removeTooltips();
        }
        if (attrClass === OVERLAY) {
            if (_showColorPicker === true) {
                removeColorPicker();
            }
        }
    });


    function zoomInX(zoomInFactor) {
        if (zoomInFactor) {
            _displayWidth = _displayWidth * zoomInFactor;
        }
        else {
            _displayWidth = _displayWidth * BUTTON_ZOOM_IN_FACTOR;
        }
        update(null, 0);
    }

    function zoomInY(zoomInFactor) {
        if (zoomInFactor) {
            _displayHeight = _displayHeight * zoomInFactor;
        }
        else {
            _displayHeight = _displayHeight * BUTTON_ZOOM_IN_FACTOR;
        }
        update(null, 0);
    }

    function zoomOutX(zoomOutFactor) {
        var newDisplayWidth;
        if (zoomOutFactor) {
            newDisplayWidth = _displayWidth * zoomOutFactor;
        }
        else {
            newDisplayWidth = _displayWidth * BUTTON_ZOOM_OUT_FACTOR;
        }
        if ((newDisplayWidth - calcMaxTreeLengthForDisplay() ) >= 1) {
            _displayWidth = newDisplayWidth;
            update(null, 0);
        }
    }

    function zoomOutY(zoomOutFactor) {
        if (zoomOutFactor) {
            _displayHeight = _displayHeight * zoomOutFactor;
        }
        else {
            _displayHeight = _displayHeight * BUTTON_ZOOM_OUT_FACTOR;
        }
        var min = 0.25 * _settings.displayHeight;
        if (_displayHeight < min) {
            _displayHeight = min;
        }
        update(null, 0);
    }

    function zoomFit() {
        if (_root) {
            calcMaxExtLabel();
            intitializeDisplaySize();
            initializeSettings(_settings);
            removeColorPicker();
            _zoomListener.scale(1);
            update(_root, 0);
            centerNode(_root, _settings.rootOffset);
        }
    }

    function returnToSupertreeButtonPressed() {
        if (_root && _superTreeRoots.length > 0) {
            _root = _superTreeRoots.pop();
            resetDepthCollapseDepthValue();
            resetRankCollapseRankValue();
            resetBranchLengthCollapseValue();
            zoomFit();
        }
    }

    function orderButtonPressed() {
        if (_root) {
            if (!_treeFn.visData) {
                _treeFn.visData = {};
            }
            if (_treeFn.visData.order === undefined) {
                _treeFn.visData.order = true;
            }
            orderSubtree(_root, _treeFn.visData.order);
            _treeFn.visData.order = !_treeFn.visData.order;
            update(null, 0);
        }
    }

    function uncollapseAllButtonPressed() {
        if (_root && forester.isHasCollapsedNodes(_root)) {
            unCollapseAll(_root);
            resetDepthCollapseDepthValue();
            resetRankCollapseRankValue();
            resetBranchLengthCollapseValue();
            resetCollapseByFeature();
            zoomFit();
        }
    }

    function escPressed() {
        if (_settings.enableNodeVisualizations || _settings.enableBranchVisualizations) {
            legendReset();
        }
        zoomFit();
        var c0 = $('#' + _settings.controls0);
        if (c0) {
            c0.css({
                'left': _settings.controls0Left,
                'top': _settings.controls0Top + _offsetTop
            });
        }
        var c1 = $('#' + _settings.controls1);
        if (c1) {
            c1.css({
                'left': _settings.controls1Left,
                'top': _settings.controls1Top + _offsetTop
            });
        }
    }

    function search0() {
        _foundNodes0.clear();
        _searchBox0Empty = true;
        var query = $('#' + SEARCH_FIELD_0).val();
        if (query && query.length > 0) {
            var my_query = query.trim();
            if (my_query.length > 0) {
                _searchBox0Empty = false;
                _foundNodes0 = search(my_query);
            }
        }
        update(null, 0, true);
    }

    function search1() {
        _foundNodes1.clear();
        _searchBox1Empty = true;
        var query = $('#' + SEARCH_FIELD_1).val();
        if (query && query.length > 0) {
            var my_query = query.trim();
            if (my_query.length > 0) {
                _searchBox1Empty = false;
                _foundNodes1 = search(my_query);
            }
        }
        update(null, 0, true);
    }

    function resetSearch0() {
        _foundNodes0.clear();
        _searchBox0Empty = true;
        $('#' + SEARCH_FIELD_0).val('');
        update(null, 0, true);
        update(null, 0, true);
    }

    function resetSearch1() {
        _foundNodes1.clear();
        _searchBox1Empty = true;
        $('#' + SEARCH_FIELD_1).val('');
        update(null, 0, true);
        update(null, 0, true);
    }


    function search(query) {
        return forester.searchData(query,
            _treeData,
            _options.searchIsCaseSensitive,
            _options.searchIsPartial,
            _options.searchUsesRegex);
    }


    function toPhylogram() {
        _options.phylogram = true;
        _options.alignPhylogram = false;
        setDisplayTypeButtons();
        update(null, 0);
    }

    function toAlignedPhylogram() {
        _options.phylogram = true;
        _options.alignPhylogram = true;
        setDisplayTypeButtons();
        update(null, 0);
    }

    function toCladegram() {
        _options.phylogram = false;
        _options.alignPhylogram = false;
        setDisplayTypeButtons();
        update(null, 0);
    }

    function nodeNameCbClicked() {
        _options.showNodeName = getCheckboxValue(NODE_NAME_CB);
        if (_options.showNodeName) {
            _options.showExternalLabels = true;
            setCheckboxValue(EXTERNAL_LABEL_CB, true);
        }
        update();
    }

    function taxonomyCbClicked() {
        _options.showTaxonomy = getCheckboxValue(TAXONOMY_CB);
        if (_options.showTaxonomy) {
            _options.showExternalLabels = true;
            setCheckboxValue(EXTERNAL_LABEL_CB, true);
        }
        update();
    }

    function sequenceCbClicked() {
        _options.showSequence = getCheckboxValue(SEQUENCE_CB);
        if (_options.showSequence) {
            _options.showExternalLabels = true;
            setCheckboxValue(EXTERNAL_LABEL_CB, true);
        }
        update();
    }

    function confidenceValuesCbClicked() {
        _options.showConfidenceValues = getCheckboxValue(CONFIDENCE_VALUES_CB);
        update();
    }

    function branchLengthsCbClicked() {
        _options.showBranchLengthValues = getCheckboxValue(BRANCH_LENGTH_VALUES_CB);
        update();
    }

    function nodeEventsCbClicked() {
        _options.showNodeEvents = getCheckboxValue(NODE_EVENTS_CB);
        update();
    }

    function branchEventsCbClicked() {
        _options.showBranchEvents = getCheckboxValue(BRANCH_EVENTS_CB);
        update();
    }

    function internalLabelsCbClicked() {
        _options.showInternalLabels = getCheckboxValue(INTERNAL_LABEL_CB);
        update();
    }

    function externalLabelsCbClicked() {
        _options.showExternalLabels = getCheckboxValue(EXTERNAL_LABEL_CB);
        update();
    }

    function internalNodesCbClicked() {
        _options.showInternalNodes = getCheckboxValue(INTERNAL_NODES_CB);
        update();
    }

    function externalNodesCbClicked() {
        _options.showExternalNodes = getCheckboxValue(EXTERNAL_NODES_CB);
        update();
    }

    function nodeVisCbClicked() {
        _options.showNodeVisualizations = getCheckboxValue(NODE_VIS_CB);
        resetVis();
        update(null, 0);
        update(null, 0);
    }

    function branchVisCbClicked() {
        _options.showBranchVisualizations = getCheckboxValue(BRANCH_VIS_CB);
        resetVis();
        update(null, 0);
        update(null, 0);
    }

    function dynaHideCbClicked() {
        _options.dynahide = getCheckboxValue(DYNAHIDE_CB);
        resetVis();
        update(null, 0);
        update(null, 0);
    }

    function downloadButtonPressed() {
        var s = $('#' + EXPORT_FORMAT_SELECT);
        if (s) {
            var format = s.val();
            downloadTree(format);
        }
    }

    function changeBranchWidth(e, slider) {
        _options.branchWidthDefault = getSliderValue(slider);
        update(null, 0, true);
    }

    function changeNodeSize(e, slider) {
        _options.nodeSizeDefault = getSliderValue(slider);
        if (!_options.showInternalNodes && !_options.showExternalNodes && !_options.showNodeVisualizations
            && !_options.showNodeEvents) {
            _options.showInternalNodes = true;
            _options.showExternalNodes = true;
            setCheckboxValue(INTERNAL_NODES_CB, true);
            setCheckboxValue(EXTERNAL_NODES_CB, true);
        }
        update(null, 0, true);
    }


    function changeInternalFontSize(e, slider) {
        _options.internalNodeFontSize = getSliderValue(slider);
        update(null, 0, true);
    }

    function changeExternalFontSize(e, slider) {
        _options.externalNodeFontSize = getSliderValue(slider);
        update(null, 0, true);
    }

    function changeBranchDataFontSize(e, slider) {
        _options.branchDataFontSize = getSliderValue(slider);
        update(null, 0, true);
    }

    function searchOptionsCaseSenstiveCbClicked() {
        _options.searchIsCaseSensitive = getCheckboxValue(SEARCH_OPTIONS_CASE_SENSITIVE_CB);
        search0();
        search1();
    }

    function searchOptionsCompleteTermsOnlyCbClicked() {
        _options.searchIsPartial = !getCheckboxValue(SEARCH_OPTIONS_COMPLETE_TERMS_ONLY_CB);
        if (_options.searchIsPartial === false) {
            _options.searchUsesRegex = false;
            setCheckboxValue(SEARCH_OPTIONS_REGEX_CB, _options.searchUsesRegex);
        }
        search0();
        search1();
    }

    function searchOptionsRegexCbClicked() {
        _options.searchUsesRegex = getCheckboxValue(SEARCH_OPTIONS_REGEX_CB);
        if (_options.searchUsesRegex === true) {
            _options.searchIsPartial = true;
            setCheckboxValue(SEARCH_OPTIONS_COMPLETE_TERMS_ONLY_CB, !_options.searchIsPartial);
        }
        search0();
        search1();
    }

    function searchOptionsNegateResultCbClicked() {
        _options.searchNegateResult = getCheckboxValue(SEARCH_OPTIONS_NEGATE_RES_CB);
        search0();
        search1();
    }


    function legendMoveUp(x) {
        if (!x) {
            x = 10;
        }
        if (_options.visualizationsLegendYpos > 0) {
            _options.visualizationsLegendYpos -= x;
            removeColorPicker();
            update(null, 0);
        }
    }

    function legendMoveDown(x) {
        if (!x) {
            x = 10;
        }
        if (_options.visualizationsLegendYpos < _settings.displayHeight) {
            _options.visualizationsLegendYpos += x;
            removeColorPicker();
            update(null, 0);
        }
    }

    function legendMoveRight(x) {
        if (!x) {
            x = 10;
        }
        if (_options.visualizationsLegendXpos < _settings.displayWidth) {
            _options.visualizationsLegendXpos += x;
            removeColorPicker();
            update(null, 0);
        }
    }

    function legendMoveLeft(x) {
        if (!x) {
            x = 10;
        }
        if (_options.visualizationsLegendXpos > 0) {
            _options.visualizationsLegendXpos -= x;
            removeColorPicker();
            update(null, 0);
        }
    }

    function moveLegendWithMouse(ev) {
        var x = ev.layerX;
        var y = ev.layerY - _offsetTop;
        if (x > 0 && x < _displayWidth) {
            _options.visualizationsLegendXpos = x;
        }
        if (y > 0 && y < _displayHeight) {
            _options.visualizationsLegendYpos = y;
        }
        removeColorPicker();
        update(null, 0);
    }

    function legendHorizVertClicked() {
        if (_options.visualizationsLegendOrientation === VERTICAL) {
            _options.visualizationsLegendOrientation = HORIZONTAL;
        }
        else {
            _options.visualizationsLegendOrientation = VERTICAL;
        }
        removeColorPicker();
        update(null, 0);
    }

    function legendShowClicked() {
        _showLegends = !_showLegends;
        if (!_showLegends) {
            removeColorPicker();
        }
        update(null, 0);
    }

    function legendResetClicked() {
        removeColorPicker();
        legendReset();
        update(null, 0);
    }

    function legendReset() {
        _options.visualizationsLegendXpos = _options.visualizationsLegendXposOrig;
        _options.visualizationsLegendYpos = _options.visualizationsLegendYposOrig;
    }

    function legendColorRectClicked(targetScale, legendLabel, legendDescription, clickedName, clickedIndex) {

        addColorPicker(targetScale, legendLabel, legendDescription, clickedName, clickedIndex);
        update();
    }

    function setRadioButtonValue(id, value) {
        var radio = $('#' + id);
        if (radio) {
            radio[0].checked = value;
            radio.button('refresh');
        }
    }

    function setCheckboxValue(id, value) {
        var cb = $('#' + id);
        if (cb && cb[0]) {
            cb[0].checked = value;
            cb.button('refresh');
        }
    }

    function getCheckboxValue(id) {
        return $('#' + id).is(':checked');
    }

    function getSliderValue(slider) {
        return slider.value;
    }

    function setSliderValue(id, value) {
        var sli = $('#' + id);
        if (sli) {
            sli.slider('value', value);
        }
    }

    function increaseFontSizes() {
        var step = SLIDER_STEP * 2;
        var max = FONT_SIZE_MAX - step;
        var up = false;
        if (_options.externalNodeFontSize <= max) {
            _options.externalNodeFontSize += step;
            up = true;
        }
        if (_options.internalNodeFontSize <= max) {
            _options.internalNodeFontSize += step;
            up = true;
        }
        if (_options.branchDataFontSize <= max) {
            _options.branchDataFontSize += step;
            up = true;
        }
        if (up) {
            setSliderValue(EXTERNAL_FONT_SIZE_SLIDER, _options.externalNodeFontSize);
            setSliderValue(INTERNAL_FONT_SIZE_SLIDER, _options.internalNodeFontSize);
            setSliderValue(BRANCH_DATA_FONT_SIZE_SLIDER, _options.branchDataFontSize);
            update(null, 0, true);
        }
    }

    function decreaseFontSizes() {
        var step = SLIDER_STEP * 2;
        var min = FONT_SIZE_MIN + step;
        var up = false;
        if (_options.externalNodeFontSize >= min) {
            _options.externalNodeFontSize -= step;
            up = true;
        }
        if (_options.internalNodeFontSize >= min) {
            _options.internalNodeFontSize -= step;
            up = true;
        }
        if (_options.branchDataFontSize >= min) {
            _options.branchDataFontSize -= step;
            up = true;
        }
        if (up) {
            setSliderValue(EXTERNAL_FONT_SIZE_SLIDER, _options.externalNodeFontSize);
            setSliderValue(INTERNAL_FONT_SIZE_SLIDER, _options.internalNodeFontSize);
            setSliderValue(BRANCH_DATA_FONT_SIZE_SLIDER, _options.branchDataFontSize);
            update(null, 0, true);
        }
    }


    function createGui() {

        var d3selectId = d3.select(_id);
        if (d3selectId && d3selectId[0]) {
            var phyloDiv = d3selectId[0][0];
            if (phyloDiv) {
                _offsetTop = phyloDiv.offsetTop;
                phyloDiv.style.textAlign = 'left';
            }
        }


        var c0 = $('#' + _settings.controls0);
        
        var y = document.getElementById("phylogram1").offsetTop;
        var x = document.getElementById("phylogram1").offsetLeft;

        if (c0) {
            c0.css({
                'position': 'fixed',
                'left': x,
                'top': y + 2,
                'padding': '0.1em',
                'opacity': '1',
                'background-color': _settings.controlsBackgroundColor,
                'color': _settings.controlsFontColor,
                'font-size': _settings.controlsFontSize,
                'font-family': _settings.controlsFont,
                'font-style': 'normal',
                'font-weight': 'normal',
                'text-decoration': 'none'
            });

            c0.draggable({containment: ''});

            c0.append(makeProgramDesc());

            c0.append(makePhylogramControl());

            c0.append(makeDisplayControl());

            c0.append(makeZoomControl());

            var pn = $('.' + PROG_NAME);
            if (pn) {
                pn.css({
                    'text-align': 'center',
                    'padding-top': '3px',
                    'padding-bottom': '5px',
                    'font-size': _settings.controlsFontSize,
                    'font-family': _settings.controlsFont,
                    'font-style': 'italic',
                    'font-weight': 'bold',
                    'text-decoration': 'none'
                });
            }
            var pnl = $('.' + PROGNAMELINK);
            if (pnl) {
                pnl.css({
                    'color': COLOR_FOR_ACTIVE_ELEMENTS,
                    'font-size': _settings.controlsFontSize,
                    'font-family': _settings.controlsFont,
                    'font-style': 'italic',
                    'font-weight': 'bold',
                    'text-decoration': 'none',
                    'border': 'none'
                });
                $('.' + PROGNAMELINK + ':hover').css({
                    'color': COLOR_FOR_ACTIVE_ELEMENTS,
                    'font-size': _settings.controlsFontSize,
                    'font-family': _settings.controlsFont,
                    'font-style': 'italic',
                    'font-weight': 'bold',
                    'text-decoration': 'none',
                    'border': 'none'
                });
                $('.' + PROGNAMELINK + ':link').css({
                    'color': COLOR_FOR_ACTIVE_ELEMENTS,
                    'font-size': _settings.controlsFontSize,
                    'font-family': _settings.controlsFont,
                    'font-style': 'italic',
                    'font-weight': 'bold',
                    'text-decoration': 'none',
                    'border': 'none'
                });
                $('.' + PROGNAMELINK + ':visited').css({
                    'color': COLOR_FOR_ACTIVE_ELEMENTS,
                    'font-size': _settings.controlsFontSize,
                    'font-family': _settings.controlsFont,
                    'font-style': 'italic',
                    'font-weight': 'bold',
                    'text-decoration': 'none',
                    'border': 'none'
                });
            }

            $('.' + PHYLOGRAM_CLADOGRAM_CONTROLGROUP).controlgroup({
                'direction': 'horizontal',
                'width': '120px'
            });

            $('.' + DISPLAY_DATA_CONTROLGROUP).controlgroup({
                'direction': 'vertical',
                'width': '120px'
            });

            c0.append(makeControlButtons());

            c0.append(makeSliders());

            c0.append(makeSearchBoxes());

            $('.' + SEARCH_OPTIONS_GROUP).controlgroup({
                'direction': 'horizontal'
            });

            c0.append(makeAutoCollapse());

            if (_settings.enableDownloads) {
                c0.append(makeDownloadSection());
            }
        }

        var c1 = $('#' + _settings.controls1);
        if (c1) {
            c1.css({
                'position': 'absolute',
                'left': _settings.controls1Left,
                'top': _settings.controls1Top + _offsetTop,
                'text-align': 'left',
                'padding': '0.1em',
                'opacity': '0.85',
                'background-color': _settings.controlsBackgroundColor,
                'color': _settings.controlsFontColor,
                'font-size': _settings.controlsFontSize,
                'font-family': _settings.controlsFont,
                'font-style': 'normal',
                'font-weight': 'normal',
                'text-decoration': 'none'
            });

            c1.draggable({containment: 'parent'});

            if (_settings.enableNodeVisualizations && _nodeVisualizations) {
                c1.append(makeVisualControls());
                c1.append(makeLegendControl());
            }
        }

        $('input:button')
            .button()
            .css({
                'width': '26px',
                'text-align': 'center',
                'outline': 'none',
                'margin': '0px',
                'font-style': 'normal',
                'font-weight': 'normal',
                'text-decoration': 'none'
            });

        $('#' + ZOOM_IN_Y + ', #' + ZOOM_OUT_Y)
            .css({
                'width': '78px'
            });

        $('#' + ZOOM_IN_Y + ', #' + ZOOM_OUT_Y + ', #' + ZOOM_TO_FIT + ', #' + ZOOM_IN_X + ', #' + ZOOM_OUT_X)
            .css({
                'height': '16px'
            });


        $('#' + DECR_DEPTH_COLLAPSE_LEVEL + ', #' + INCR_DEPTH_COLLAPSE_LEVEL + ', #' + DECR_BL_COLLAPSE_LEVEL + ', #' + INCR_BL_COLLAPSE_LEVEL)
            .css({
                'width': '16px'
            });

        $('#' + LEGENDS_MOVE_UP_BTN + ', #' + LEGENDS_MOVE_DOWN_BTN)
            .css({
                'width': '72px'
            });

        $('#' + LEGENDS_RESET_BTN + ', #' + LEGENDS_MOVE_LEFT_BTN + ', #' + LEGENDS_MOVE_RIGHT_BTN)
            .css({
                'width': '24px'
            });

        $('#' + LEGENDS_SHOW_BTN + ', #' + LEGENDS_HORIZ_VERT_BTN)
            .css({
                'width': '36px'
            });

        $('#' + LEGENDS_MOVE_UP_BTN + ', #' + LEGENDS_MOVE_DOWN_BTN + ', #' +
            LEGENDS_RESET_BTN + ', #' + LEGENDS_MOVE_LEFT_BTN + ', #' + LEGENDS_MOVE_RIGHT_BTN +
            ', #' + LEGENDS_SHOW_BTN + ', #' + LEGENDS_HORIZ_VERT_BTN
        )
            .css({
                'height': '16px'
            });


        var downloadButton = $('#' + DOWNLOAD_BUTTON);

        if (downloadButton) {
            downloadButton.css({
                'width': '60px',
                'margin-bottom': '3px'
            });
        }

        $(':radio').checkboxradio({
            icon: false
        });

        $(':checkbox').checkboxradio({
            icon: false
        });

        $('#' + SEARCH_FIELD_0).keyup(search0);

        $('#' + SEARCH_FIELD_1).keyup(search1);

        $('#' + PHYLOGRAM_BUTTON).click(toPhylogram);

        $('#' + PHYLOGRAM_ALIGNED_BUTTON).click(toAlignedPhylogram);

        $('#' + CLADOGRAM_BUTTON).click(toCladegram);

        $('#' + NODE_NAME_CB).click(nodeNameCbClicked);

        $('#' + TAXONOMY_CB).click(taxonomyCbClicked);

        $('#' + SEQUENCE_CB).click(sequenceCbClicked);

        $('#' + CONFIDENCE_VALUES_CB).click(confidenceValuesCbClicked);

        $('#' + BRANCH_LENGTH_VALUES_CB).click(branchLengthsCbClicked);

        $('#' + NODE_EVENTS_CB).click(nodeEventsCbClicked);

        $('#' + BRANCH_EVENTS_CB).click(branchEventsCbClicked);

        $('#' + INTERNAL_LABEL_CB).click(internalLabelsCbClicked);

        $('#' + EXTERNAL_LABEL_CB).click(externalLabelsCbClicked);

        $('#' + INTERNAL_NODES_CB).click(internalNodesCbClicked);

        $('#' + EXTERNAL_NODES_CB).click(externalNodesCbClicked);

        $('#' + NODE_VIS_CB).click(nodeVisCbClicked);

        $('#' + BRANCH_VIS_CB).click(branchVisCbClicked);

        $('#' + DYNAHIDE_CB).click(dynaHideCbClicked);

        $('#' + LABEL_COLOR_SELECT_MENU).on('change', function () {
            var v = this.value;
            if (v && v != DEFAULT) {
                _currentLabelColorVisualization = v;
                addLegend(LEGEND_LABEL_COLOR, _visualizations.labelColor[_currentLabelColorVisualization]);
            }
            else {
                _currentLabelColorVisualization = null;
                removeLegend(LEGEND_LABEL_COLOR);
            }
            removeColorPicker();
            update(null, 0);
        });

        $('#' + NODE_FILL_COLOR_SELECT_MENU).on('change', function () {
            var v = this.value;
            if (v && v != DEFAULT) {
                if (!_options.showExternalNodes && !_options.showInternalNodes
                    && ( _currentNodeShapeVisualization == null )) {
                    _options.showExternalNodes = true;
                    setCheckboxValue(EXTERNAL_NODES_CB, true);
                }
                _options.showNodeVisualizations = true;
                setCheckboxValue(NODE_VIS_CB, true);
                _currentNodeFillColorVisualization = v;
                addLegend(LEGEND_NODE_FILL_COLOR, _visualizations.nodeFillColor[_currentNodeFillColorVisualization]);
            }
            else {
                _currentNodeFillColorVisualization = null;
                removeLegend(LEGEND_NODE_FILL_COLOR);
            }
            removeColorPicker();
            update(null, 0);
        });

        $('#' + NODE_BORDER_COLOR_SELECT_MENU).on('change', function () {
            var v = this.value;
            if (v && v != DEFAULT) {
                _currentNodeBorderColorVisualization = v;
                if ((v != SAME_AS_FILL ) && (v != NONE)) {
                    addLegend(LEGEND_NODE_BORDER_COLOR, _visualizations.nodeBorderColor[_currentNodeBorderColorVisualization]);
                    if (!_options.showExternalNodes && !_options.showInternalNodes
                        && ( _currentNodeShapeVisualization == null )) {
                        _options.showExternalNodes = true;
                        setCheckboxValue(EXTERNAL_NODES_CB, true);
                    }
                    _options.showNodeVisualizations = true;
                    setCheckboxValue(NODE_VIS_CB, true);
                }
            }
            else {
                _currentNodeBorderColorVisualization = null;

            }
            if ((v == DEFAULT ) || (v == SAME_AS_FILL ) || (v == NONE)) {
                removeLegend(LEGEND_NODE_BORDER_COLOR);
            }
            removeColorPicker();
            update(null, 0);
        });

        $('#' + NODE_SHAPE_SELECT_MENU).on('change', function () {
            var v = this.value;
            if (v && v != DEFAULT) {
                _currentNodeShapeVisualization = v;
                addLegendForShapes(LEGEND_NODE_SHAPE, _visualizations.nodeShape[_currentNodeShapeVisualization]);
                _options.showNodeVisualizations = true;
                setCheckboxValue(NODE_VIS_CB, true);
            }
            else {
                _currentNodeShapeVisualization = null;
                removeLegendForShapes(LEGEND_NODE_SHAPE);
            }
            removeColorPicker();
            resetVis();
            update(null, 0);
            update(null, 0);
        });

        $('#' + NODE_SIZE_SELECT_MENU).on('change', function () {
            var v = this.value;
            if (v && v != DEFAULT) {
                _currentNodeSizeVisualization = v;
                addLegendForSizes(LEGEND_NODE_SIZE, _visualizations.nodeSize[_currentNodeSizeVisualization]);
                if (!_options.showExternalNodes && !_options.showInternalNodes
                    && ( _currentNodeShapeVisualization == null )) {
                    _options.showExternalNodes = true;
                    setCheckboxValue(EXTERNAL_NODES_CB, true);
                }
                _options.showNodeVisualizations = true;
                setCheckboxValue(NODE_VIS_CB, true);
            }
            else {
                _currentNodeSizeVisualization = null;
                removeLegendForSizes(LEGEND_NODE_SIZE);
            }
            removeColorPicker();
            update(null, 0);
        });


        $('#' + NODE_SIZE_SLIDER).slider({
            min: NODE_SIZE_MIN,
            max: NODE_SIZE_MAX,
            step: SLIDER_STEP,
            value: _options.nodeSizeDefault,
            animate: 'fast',
            slide: changeNodeSize,
            change: changeNodeSize
        });

        $('#' + BRANCH_WIDTH_SLIDER).slider({
            min: BRANCH_WIDTH_MIN,
            max: BRANCH_WIDTH_MAX,
            step: SLIDER_STEP,
            value: _options.branchWidthDefault,
            animate: 'fast',
            slide: changeBranchWidth,
            change: changeBranchWidth
        });

        $('#' + EXTERNAL_FONT_SIZE_SLIDER).slider({
            min: FONT_SIZE_MIN,
            max: FONT_SIZE_MAX,
            step: SLIDER_STEP,
            value: _options.externalNodeFontSize,
            animate: 'fast',
            slide: changeExternalFontSize,
            change: changeExternalFontSize
        });

        $('#' + INTERNAL_FONT_SIZE_SLIDER).slider({
            min: FONT_SIZE_MIN,
            max: FONT_SIZE_MAX,
            step: SLIDER_STEP,
            value: _options.internalNodeFontSize,
            animate: 'fast',
            slide: changeInternalFontSize,
            change: changeInternalFontSize
        });

        $('#' + BRANCH_DATA_FONT_SIZE_SLIDER).slider({
            min: FONT_SIZE_MIN,
            max: FONT_SIZE_MAX,
            step: SLIDER_STEP,
            value: _options.branchDataFontSize,
            animate: 'fast',
            slide: changeBranchDataFontSize,
            change: changeBranchDataFontSize
        });

        $('#' + SEARCH_FIELD_0 + ', #' + SEARCH_FIELD_1)
            .button()
            .off('keydown')
            .off('mouseenter')
            .off('mousedown')
            .css({
                'font': 'inherit',
                'color': 'inherit',
                'text-align': 'left',
                'outline': 'none',
                'cursor': 'text',
                'width': '38px'
            });

        $('#' + DEPTH_COLLAPSE_LABEL + ', #' + BL_COLLAPSE_LABEL)
            .button()
            .off('keydown')
            .off('mouseenter')
            .off('mousedown')
            .attr('disabled', 'disabled')
            .css({
                'font': 'inherit',
                'color': 'inherit',
                'text-align': 'center',
                'outline': 'none',
                'cursor': 'text',
                'width': '18px'
            });

        $('#' + ZOOM_IN_Y).mousedown(function () {
            zoomInY();
            _intervalId = setInterval(zoomInY, ZOOM_INTERVAL);
        }).bind('mouseup mouseleave', function () {
            clearTimeout(_intervalId);
        });

        $('#' + ZOOM_OUT_Y).mousedown(function () {
            zoomOutY();
            _intervalId = setInterval(zoomOutY, ZOOM_INTERVAL);
        }).bind('mouseup mouseleave', function () {
            clearTimeout(_intervalId);
        });

        $('#' + ZOOM_IN_X).mousedown(function () {
            zoomInX();
            _intervalId = setInterval(zoomInX, ZOOM_INTERVAL);
        }).bind('mouseup mouseleave', function () {
            clearTimeout(_intervalId);
        });

        $('#' + ZOOM_OUT_X).mousedown(function () {
            zoomOutX();
            _intervalId = setInterval(zoomOutX, ZOOM_INTERVAL);
        }).bind('mouseup mouseleave', function () {
            clearTimeout(_intervalId);
        });

        $('#' + DECR_DEPTH_COLLAPSE_LEVEL).mousedown(function () {
            decrDepthCollapseLevel();
            _intervalId = setInterval(decrDepthCollapseLevel, ZOOM_INTERVAL);
        }).bind('mouseup mouseleave', function () {
            clearTimeout(_intervalId);
        });
        $('#' + INCR_DEPTH_COLLAPSE_LEVEL).mousedown(function () {
            incrDepthCollapseLevel();
            _intervalId = setInterval(incrDepthCollapseLevel, ZOOM_INTERVAL);
        }).bind('mouseup mouseleave', function () {
            clearTimeout(_intervalId);
        });
        $('#' + DECR_BL_COLLAPSE_LEVEL).mousedown(function () {
            decrBlCollapseLevel();
            _intervalId = setInterval(decrBlCollapseLevel, ZOOM_INTERVAL);
        }).bind('mouseup mouseleave', function () {
            clearTimeout(_intervalId);
        });
        $('#' + INCR_BL_COLLAPSE_LEVEL).mousedown(function () {
            incrBlCollapseLevel();
            _intervalId = setInterval(incrBlCollapseLevel, ZOOM_INTERVAL);
        }).bind('mouseup mouseleave', function () {
            clearTimeout(_intervalId);
        });

        $('#' + ZOOM_TO_FIT).mousedown(zoomFit);

        $('#' + RETURN_TO_SUPERTREE_BUTTON).mousedown(returnToSupertreeButtonPressed);

        $('#' + ORDER_BUTTON).mousedown(orderButtonPressed);

        $('#' + UNCOLLAPSE_ALL_BUTTON).mousedown(uncollapseAllButtonPressed);

        $('#' + SEARCH_OPTIONS_CASE_SENSITIVE_CB).click(searchOptionsCaseSenstiveCbClicked);
        $('#' + SEARCH_OPTIONS_COMPLETE_TERMS_ONLY_CB).click(searchOptionsCompleteTermsOnlyCbClicked);
        $('#' + SEARCH_OPTIONS_REGEX_CB).click(searchOptionsRegexCbClicked);
        $('#' + SEARCH_OPTIONS_NEGATE_RES_CB).click(searchOptionsNegateResultCbClicked);

        $('#' + RESET_SEARCH_A_BTN).mousedown(resetSearch0);
        $('#' + RESET_SEARCH_B_BTN).mousedown(resetSearch1);

        $('#' + LEGENDS_MOVE_UP_BTN).mousedown(function () {
            legendMoveUp(2);
            _intervalId = setInterval(legendMoveUp, MOVE_INTERVAL);
        }).bind('mouseup mouseleave', function () {
            clearTimeout(_intervalId);
        });

        $('#' + LEGENDS_MOVE_DOWN_BTN).mousedown(function () {
            legendMoveDown(2);
            _intervalId = setInterval(legendMoveDown, MOVE_INTERVAL);
        }).bind('mouseup mouseleave', function () {
            clearTimeout(_intervalId);
        });

        $('#' + LEGENDS_MOVE_LEFT_BTN).mousedown(function () {
            legendMoveLeft(2);
            _intervalId = setInterval(legendMoveLeft, MOVE_INTERVAL);
        }).bind('mouseup mouseleave', function () {
            clearTimeout(_intervalId);
        });

        $('#' + LEGENDS_MOVE_RIGHT_BTN).mousedown(function () {
            legendMoveRight(2);
            _intervalId = setInterval(legendMoveRight, MOVE_INTERVAL);
        }).bind('mouseup mouseleave', function () {
            clearTimeout(_intervalId);
        });

        $('#' + LEGENDS_HORIZ_VERT_BTN).click(legendHorizVertClicked);
        $('#' + LEGENDS_SHOW_BTN).click(legendShowClicked);
        $('#' + LEGENDS_RESET_BTN).click(legendResetClicked);

        if (downloadButton) {
            downloadButton.mousedown(downloadButtonPressed);
        }

        $('#' + COLLAPSE_BY_FEATURE_SELECT)
            .select()
            .css({
                'font': 'inherit',
                'color': 'inherit'
            });

        $('#' + EXPORT_FORMAT_SELECT)
            .select()
            .css({
                'font': 'inherit',
                'color': 'inherit'
            });

        $('#' + COLLAPSE_BY_FEATURE_SELECT).on('change', function () {
            var s = $('#' + COLLAPSE_BY_FEATURE_SELECT);
            if (s) {
                var f = s.val();
                if (f) {
                    collapseByFeature(f);
                }
            }
        });

        $('#' + LABEL_COLOR_SELECT_MENU)
            .select()
            .css({
                'font': 'inherit',
                'color': 'inherit'
            });

        $('#' + NODE_FILL_COLOR_SELECT_MENU)
            .select()
            .css({
                'font': 'inherit',
                'color': 'inherit'
            });

        $('#' + NODE_BORDER_COLOR_SELECT_MENU)
            .select()
            .css({
                'font': 'inherit',
                'color': 'inherit'
            });

        $('#' + NODE_SHAPE_SELECT_MENU)
            .select()
            .css({
                'font': 'inherit',
                'color': 'inherit'
            });

        $('#' + NODE_SIZE_SELECT_MENU)
            .select()
            .css({
                'font': 'inherit',
                'color': 'inherit'
            });

        $(document).keyup(function (e) {
            if (e.altKey) {
                if (e.keyCode === VK_O) {
                    orderButtonPressed();
                }
                else if (e.keyCode === VK_R) {
                    returnToSupertreeButtonPressed();
                }
                else if (e.keyCode === VK_U) {
                    uncollapseAllButtonPressed();
                }
                else if (e.keyCode === VK_C || e.keyCode === VK_DELETE
                    || e.keyCode === VK_BACKSPACE || e.keyCode === VK_HOME) {
                    zoomFit();
                }
                else if (e.keyCode === VK_P) {
                    cycleDisplay();
                }
                else if (e.keyCode === VK_L) {
                    toggleAlignPhylogram();
                }
            }
            else if (e.keyCode === VK_HOME) {
                zoomFit();
            }
            else if (e.keyCode === VK_ESC) {
                escPressed();
            }
        });

        $(document).keydown(function (e) {
            if (e.altKey) {
                if (e.keyCode === VK_UP) {
                    zoomInY(BUTTON_ZOOM_IN_FACTOR_SLOW);
                }
                else if (e.keyCode === VK_DOWN) {
                    zoomOutY(BUTTON_ZOOM_OUT_FACTOR_SLOW);
                }
                else if (e.keyCode === VK_LEFT) {
                    zoomOutX(BUTTON_ZOOM_OUT_FACTOR_SLOW);
                }
                else if (e.keyCode === VK_RIGHT) {
                    zoomInX(BUTTON_ZOOM_IN_FACTOR_SLOW);
                }
                else if (e.keyCode === VK_PLUS || e.keyCode === VK_PLUS_N) {
                    if (e.shiftKey) {
                        increaseFontSizes();
                    }
                    else {
                        zoomInY(BUTTON_ZOOM_IN_FACTOR_SLOW);
                        zoomInX(BUTTON_ZOOM_IN_FACTOR_SLOW);
                    }
                }
                else if (e.keyCode === VK_MINUS || e.keyCode === VK_MINUS_N) {
                    if (e.shiftKey) {
                        decreaseFontSizes();
                    }
                    else {
                        zoomOutY(BUTTON_ZOOM_OUT_FACTOR_SLOW);
                        zoomOutX(BUTTON_ZOOM_OUT_FACTOR_SLOW);
                    }
                }
                else if (e.keyCode === VK_A) {
                    decrDepthCollapseLevel();
                }
                else if (e.keyCode === VK_S) {
                    incrDepthCollapseLevel();
                }
            }
            if (e.keyCode === VK_PAGE_UP) {
                increaseFontSizes();
            }
            else if (e.keyCode === VK_PAGE_DOWN) {
                decreaseFontSizes();
            }
        });


        $(document).on('mousewheel DOMMouseScroll', function (e) {
            if (e.shiftKey) {
                if (e.originalEvent) {
                    var oe = e.originalEvent;
                    if (oe.detail > 0 || oe.wheelDelta < 0) {
                        if (e.ctrlKey) {
                            decreaseFontSizes();
                        }
                        else if (e.altKey) {
                            zoomOutX(BUTTON_ZOOM_OUT_FACTOR_SLOW);
                        }
                        else {
                            zoomOutY(BUTTON_ZOOM_OUT_FACTOR_SLOW);
                        }
                    }
                    else {
                        if (e.ctrlKey) {
                            increaseFontSizes();
                        }
                        else if (e.altKey) {
                            zoomInX(BUTTON_ZOOM_IN_FACTOR_SLOW);
                        }
                        else {
                            zoomInY(BUTTON_ZOOM_IN_FACTOR_SLOW);
                        }
                    }
                }
                // To prevent page fom scrolling:
                return false;
            }
        });

        // --------------------------------------------------------------
        // Functions to make GUI elements
        // --------------------------------------------------------------

        function makeProgramDesc() {
            var h = "";
            h = h.concat('<div class=' + PROG_NAME + '>');
            h = h.concat('<a class="' + PROGNAMELINK + '" href="' + WEBSITE + '" target="_blank">' + NAME + ' ' + VERSION + '</a>');
            h = h.concat('</div>');
            return h;
        }

        function makePhylogramControl() {
            var radioGroup = 'radio-1';
            var h = "";
            h = h.concat('<fieldset>');
            h = h.concat('<div class="' + PHYLOGRAM_CLADOGRAM_CONTROLGROUP + '">');
            h = h.concat(makeRadioButton('P', PHYLOGRAM_BUTTON, radioGroup, 'phylogram display (uses branch length values)  (use Alt+P to cycle between display types)'));
            h = h.concat(makeRadioButton('A', PHYLOGRAM_ALIGNED_BUTTON, radioGroup, 'phylogram display (uses branch length values) with aligned labels  (use Alt+P to cycle between display types)'));
            h = h.concat(makeRadioButton('C', CLADOGRAM_BUTTON, radioGroup, ' cladogram display (ignores branch length values)  (use Alt+P to cycle between display types)'));
            h = h.concat('</div>');
            h = h.concat('</fieldset>');
            return h;
        }

        function makeDisplayControl() {
            var h = "";

            h = h.concat('<fieldset><legend>Display Data</legend>');
            h = h.concat('<div class="' + DISPLAY_DATA_CONTROLGROUP + '">');
            if (_basicTreeProperties.nodeNames) {
                h = h.concat(makeCheckboxButton('Node Name', NODE_NAME_CB, 'to show/hide node names (node names usually are the untyped labels found in New Hampshire/Newick formatted trees)'));
            }
            if (_basicTreeProperties.taxonomies) {
                h = h.concat(makeCheckboxButton('Taxonomy', TAXONOMY_CB, 'to show/hide node taxonomic information'));
            }
            if (_basicTreeProperties.sequences) {
                h = h.concat(makeCheckboxButton('Sequence', SEQUENCE_CB, 'to show/hide node sequence information'));
            }
            if (_basicTreeProperties.confidences) {
                h = h.concat(makeCheckboxButton('Confidence', CONFIDENCE_VALUES_CB, 'to show/hide confidence values'));
            }
            if (_basicTreeProperties.branchLengths) {
                h = h.concat(makeCheckboxButton('Branch Length', BRANCH_LENGTH_VALUES_CB, 'to show/hide branch length values'));
            }
            if (_basicTreeProperties.nodeEvents) {
                h = h.concat(makeCheckboxButton('Node Events', NODE_EVENTS_CB, 'to show speciations and duplications as colored nodes (e.g. speciations green, duplications red)'));
            }
            if (_basicTreeProperties.branchEvents) {
                h = h.concat(makeCheckboxButton('Branch Events', BRANCH_EVENTS_CB, 'to show/hide branch events (e.g. mutations)'));
            }
            h = h.concat(makeCheckboxButton('External Labels', EXTERNAL_LABEL_CB, 'to show/hide external node labels'));
            if (_basicTreeProperties.internalNodeData) {
                h = h.concat(makeCheckboxButton('Internal Labels', INTERNAL_LABEL_CB, 'to show/hide internal node labels'));
            }
            h = h.concat(makeCheckboxButton('External Nodes', EXTERNAL_NODES_CB, 'to show external nodes as shapes (usually circles)'));
            h = h.concat(makeCheckboxButton('Internal Nodes', INTERNAL_NODES_CB, 'to show internal nodes as shapes (usually circles)'));

            if (_settings.enableNodeVisualizations) {
                h = h.concat(makeCheckboxButton('Node Vis', NODE_VIS_CB, 'to show/hide node visualizations (colors, shapes, sizes), set with the Visualizations sub-menu'));
            }
            if (_settings.enableBranchVisualizations) {
                h = h.concat(makeCheckboxButton('Branch Vis', BRANCH_VIS_CB, 'to show/hide branch visualizations, set with the Visualizations sub-menu'));
            }
            if (_settings.showDynahideButton) {
                h = h.concat(makeCheckboxButton('Dyna Hide', DYNAHIDE_CB, 'to hide external labels depending on expected visibility'));
            }
            h = h.concat('</div>');
            h = h.concat('</fieldset>');
            return h;
        }

        function makeZoomControl() {
            var h = "";
            h = h.concat('<fieldset>');
            h = h.concat('<legend>Zoom</legend>');
            h = h.concat(makeButton('Y+', ZOOM_IN_Y, 'zoom in vertically (Alt+Up or Shift+mousewheel)'));
            h = h.concat('<br>');
            h = h.concat(makeButton('X-', ZOOM_OUT_X, 'zoom out horizontally (Alt+Left or Shift+Alt+mousewheel)'));
            h = h.concat(makeButton('F', ZOOM_TO_FIT, 'fit and center tree display (Alt+C, Home, or Esc to re-position controls as well)'));
            h = h.concat(makeButton('X+', ZOOM_IN_X, 'zoom in horizontally (Alt+Right or Shift+Alt+mousewheel)'));
            h = h.concat('<br>');
            h = h.concat(makeButton('Y-', ZOOM_OUT_Y, 'zoom out vertically (Alt+Down or Shift+mousewheel)'));
            h = h.concat('</fieldset>');
            return h;
        }

        function makeControlButtons() {
            var h = "";
            h = h.concat('<fieldset>');
            h = h.concat('<legend>Tools</legend>');
            h = h.concat('<div>');
            h = h.concat(makeButton('O', ORDER_BUTTON, 'order all (Alt+O)'));
            h = h.concat(makeButton('R', RETURN_TO_SUPERTREE_BUTTON, 'return to the super-tree (if in sub-tree) (Alt+R)'));
            h = h.concat(makeButton('U', UNCOLLAPSE_ALL_BUTTON, 'uncollapse all (Alt+U)'));
            h = h.concat('</div>');
            h = h.concat('</fieldset>');
            return h;
        }

        function makeDownloadSection() {
            var h = "";
            h = h.concat('<form action="#">');
            h = h.concat('<fieldset>');
            h = h.concat('<input type="button" value="Download" name="' + DOWNLOAD_BUTTON + '" title="download/export tree in a selected format" id="' + DOWNLOAD_BUTTON + '">');
            h = h.concat('<br>');
            h = h.concat('<select name="' + EXPORT_FORMAT_SELECT + '" id="' + EXPORT_FORMAT_SELECT + '">');
            h = h.concat('<option value="' + PNG_EXPORT_FORMAT + '">' + PNG_EXPORT_FORMAT + '</option>');
            h = h.concat('<option value="' + SVG_EXPORT_FORMAT + '">' + SVG_EXPORT_FORMAT + '</option>');
            h = h.concat('<option value="' + PHYLOXML_EXPORT_FORMAT + '">' + PHYLOXML_EXPORT_FORMAT + '</option>');
            h = h.concat('<option value="' + NH_EXPORT_FORMAT + '">' + NH_EXPORT_FORMAT + '</option>');
            // h = h.concat('<option value="' + PDF_EXPORT_FORMAT + '">' + PDF_EXPORT_FORMAT + '</option>');
            h = h.concat('</select>');
            h = h.concat('</fieldset>');
            h = h.concat('</form>');
            return h;
        }

        function makeSliders() {
            var h = "";
            h = h.concat('<fieldset>');
            h = h.concat(makeSlider('External label size:', EXTERNAL_FONT_SIZE_SLIDER));
            if (_basicTreeProperties.internalNodeData) {
                h = h.concat(makeSlider('Internal label size:', INTERNAL_FONT_SIZE_SLIDER));
            }
            if (_basicTreeProperties.branchLengths || _basicTreeProperties.confidences
                || _basicTreeProperties.branchEvents) {
                h = h.concat(makeSlider('Branch label size:', BRANCH_DATA_FONT_SIZE_SLIDER));
            }
            h = h.concat(makeSlider('Node size:', NODE_SIZE_SLIDER));
            h = h.concat(makeSlider('Branch width:', BRANCH_WIDTH_SLIDER));
            h = h.concat('</fieldset>');
            return h;
        }

        function makeAutoCollapse() {
            var h = "";
            h = h.concat('<fieldset>');
            h = h.concat('<legend>Collapse Depth</legend>');
            h = h.concat(makeButton('-', DECR_DEPTH_COLLAPSE_LEVEL, 'to decrease the depth threshold (wraps around) (Alt+A)'));
            h = h.concat(makeTextInput(DEPTH_COLLAPSE_LABEL, 'the current depth threshold'));
            h = h.concat(makeButton('+', INCR_DEPTH_COLLAPSE_LEVEL, 'to increase the depth threshold (wraps around) (Alt+S)'));
            h = h.concat('</fieldset>');
            if (_settings.enableCollapseByBranchLenghts && _basicTreeProperties.branchLengths) {
                h = h.concat('<fieldset>');
                h = h.concat('<legend>Collapse Length</legend>');
                h = h.concat(makeButton('-', DECR_BL_COLLAPSE_LEVEL, 'to decrease the maximal subtree branch length threshold (wraps around)'));
                h = h.concat(makeTextInput(BL_COLLAPSE_LABEL, 'the current maximal subtree branch length threshold'));
                h = h.concat(makeButton('+', INCR_BL_COLLAPSE_LEVEL, 'to increase the maximal subtree branch length threshold (wraps around)'));
                h = h.concat('</fieldset>');
            }


            if (_settings.enableCollapseByFeature) {
                h = h.concat('<fieldset>');
                h = h.concat('<legend>Collapse Feature</legend>');
                h = h.concat('<select name="' + COLLAPSE_BY_FEATURE_SELECT + '" id="' + COLLAPSE_BY_FEATURE_SELECT + '">');
                h = h.concat('<option value="' + OFF_FEATURE + '">' + OFF_FEATURE + '</option>');
                if (_basicTreeProperties.taxonomies) {
                    h = h.concat('<option value="' + SPECIES_FEATURE + '">' + SPECIES_FEATURE + '</option>');
                }
                var refs = forester.collectPropertyRefs(_treeData, 'node', false);
                if (refs) {
                    refs.forEach(function (v) {
                        h = h.concat('<option value="' + v + '">' + v + '</option>');
                    });
                }
                h = h.concat('</select>');
                h = h.concat('</fieldset>');
            }
            return h;
        }

        function makeSearchBoxes() {

            var tooltip = "enter text to search for (use ',' for logical OR and '+' for logical AND," +
                " use expressions in form of XX:term for typed search -- e.g. NN:node name, TC:taxonomy code," +
                " TS:taxonomy scientific name, SN:sequence name, GN:gene name, SS:sequence symbol, MS:molecular sequence, ...)";
            var h = "";
            h = h.concat('<fieldset>');
            h = h.concat('<legend>Search</legend>');
            h = h.concat(makeTextInput(SEARCH_FIELD_0, tooltip));
            h = h.concat(makeButton('R', RESET_SEARCH_A_BTN, RESET_SEARCH_A_BTN_TOOLTIP));
            h = h.concat('<br>');
            h = h.concat(makeTextInput(SEARCH_FIELD_1, tooltip));
            h = h.concat(makeButton('R', RESET_SEARCH_B_BTN, RESET_SEARCH_B_BTN_TOOLTIP));
            h = h.concat('<br>');
            h = h.concat(makeSearchControls());
            h = h.concat('</fieldset>');
            return h;
        }

        function makeSearchControls() {
            var h = "";
            h = h.concat('<div class="' + SEARCH_OPTIONS_GROUP + '">');
            h = h.concat(makeCheckboxButton('Cas', SEARCH_OPTIONS_CASE_SENSITIVE_CB, 'to search in a case-sensitive manner'));
            h = h.concat(makeCheckboxButton('Wrd', SEARCH_OPTIONS_COMPLETE_TERMS_ONLY_CB, ' to match complete terms (separated by spaces or underscores) only (does not apply to regular expression search)'));
            h = h.concat('</div>');
            h = h.concat('<br>');
            h = h.concat('<div class="' + SEARCH_OPTIONS_GROUP + '">');
            h = h.concat(makeCheckboxButton('Neg', SEARCH_OPTIONS_NEGATE_RES_CB, 'to invert (negate) the search results'));
            h = h.concat(makeCheckboxButton('Reg', SEARCH_OPTIONS_REGEX_CB, 'to search with regular expressions'));
            h = h.concat('</div>');
            return h;
        }

        function makeSearchControlsCompact() {
            var h = "";
            h = h.concat('<div class="' + SEARCH_OPTIONS_GROUP + '">');
            h = h.concat(makeCheckboxButton('C', SEARCH_OPTIONS_CASE_SENSITIVE_CB, 'to search in a case-sensitive manner'));
            h = h.concat(makeCheckboxButton('W', SEARCH_OPTIONS_COMPLETE_TERMS_ONLY_CB, ' to match complete terms (separated by spaces or underscores) only (does not apply to regular expression search)'));
            h = h.concat(makeCheckboxButton('N', SEARCH_OPTIONS_NEGATE_RES_CB, 'to invert (negate) the search results'));
            h = h.concat(makeCheckboxButton('R', SEARCH_OPTIONS_REGEX_CB, 'to search with regular expressions'));
            h = h.concat('</div>');
            return h;
        }


        function makeVisualControls() {
            var h = "";
            h = h.concat('<form action="#">');
            h = h.concat('<fieldset>');
            h = h.concat('<legend>Visualizations</legend>');
            h = h.concat(makeSelectMenu('Label Color:', '<br>', LABEL_COLOR_SELECT_MENU, 'colorize the node label according to a property'));
            h = h.concat('<br>');
            h = h.concat(makeSelectMenu('Node Fill Color:', '<br>', NODE_FILL_COLOR_SELECT_MENU, 'colorize the node fill according to a property'));
            h = h.concat('<br>');
            h = h.concat(makeSelectMenu('Node Border Color:', '<br>', NODE_BORDER_COLOR_SELECT_MENU, 'colorize the node border according to a property'));
            h = h.concat('<br>');
            h = h.concat(makeSelectMenu('Node Shape:', '<br>', NODE_SHAPE_SELECT_MENU, 'change the node shape according to a property'));
            h = h.concat('<br>');
            h = h.concat(makeSelectMenu('Node Size:', '<br>', NODE_SIZE_SELECT_MENU, 'change the node size according to a property'));
            h = h.concat('</fieldset>');
            h = h.concat('</form>');
            return h;
        }


        function makeLegendControl() {
            var mouseTip = ' (alternatively, place legend with mouse using shift+left-mouse-button click, or alt+left-mouse-button click)';
            var h = "";
            h = h.concat('<fieldset>');
            h = h.concat('<legend>Vis Legend</legend>');
            h = h.concat(makeButton('Show', LEGENDS_SHOW_BTN, 'to show/hide legend(s)'));
            h = h.concat(makeButton('Dir', LEGENDS_HORIZ_VERT_BTN, 'to toggle between vertical and horizontal alignment of (multiple) legends'));
            h = h.concat('<br>');
            h = h.concat(makeButton('^', LEGENDS_MOVE_UP_BTN, 'move legend(s) up' + mouseTip));
            h = h.concat('<br>');
            h = h.concat(makeButton('<', LEGENDS_MOVE_LEFT_BTN, 'move legend(s) left' + mouseTip));
            h = h.concat(makeButton('R', LEGENDS_RESET_BTN, 'return legend(s) to original position' + mouseTip));
            h = h.concat(makeButton('>', LEGENDS_MOVE_RIGHT_BTN, 'move legend(s) right' + mouseTip));
            h = h.concat('<br>');
            h = h.concat(makeButton('v', LEGENDS_MOVE_DOWN_BTN, 'move legend(s) down' + mouseTip));
            h = h.concat('</fieldset>');
            return h;
        }


        // --------------------------------------------------------------
        // Functions to make individual GUI components
        // --------------------------------------------------------------
        function makeButton(label, id, tooltip) {
            return '<input type="button" value="' + label + '" name="' + id + '" id="' + id + '" title="' + tooltip + '">';
        }

        function makeCheckboxButton(label, id, tooltip) {
            return '<label for="' + id + '" title="' + tooltip + '">' + label + '</label><input type="checkbox" name="' + id + '" id="' + id + '">';
        }

        function makeRadioButton(label, id, radioGroup, tooltip) {
            return '<label for="' + id + '" title="' + tooltip + '">' + label + '</label><input type="radio" name="' + radioGroup + '" id="' + id + '">';
        }

        function makeSelectMenu(label, sep, id, tooltip) {
            return '<label for="' + id + '" title="' + tooltip + '">' + label + '</label>' + sep + '<select name="' + id + '" id="' + id + '"></select>';
        }

        function makeSlider(label, id) {
            return label + '<div id="' + id + '"></div>';
        }

        function makeTextInput(id, tooltip) {
            return '<input title="' + tooltip + '" type="text" name="' + id + '" id="' + id + '">';
        }

        function makeTextInputWithLabel(label, sep, id, tooltip) {
            return label + sep + '<input title="' + tooltip + '" type="text" name="' + id + '" id="' + id + '">';
        }

    } // function createGui()

    function initializeGui() {

        setDisplayTypeButtons();

        setCheckboxValue(NODE_NAME_CB, _options.showNodeName);
        setCheckboxValue(TAXONOMY_CB, _options.showTaxonomy);
        setCheckboxValue(SEQUENCE_CB, _options.showSequence);
        setCheckboxValue(CONFIDENCE_VALUES_CB, _options.showConfidenceValues);
        setCheckboxValue(BRANCH_LENGTH_VALUES_CB, _options.showBranchLengthValues);
        setCheckboxValue(NODE_EVENTS_CB, _options.showNodeEvents);
        setCheckboxValue(BRANCH_EVENTS_CB, _options.showBranchEvents);
        setCheckboxValue(INTERNAL_LABEL_CB, _options.showInternalLabels);
        setCheckboxValue(EXTERNAL_LABEL_CB, _options.showExternalLabels);
        setCheckboxValue(INTERNAL_NODES_CB, _options.showInternalNodes);
        setCheckboxValue(EXTERNAL_NODES_CB, _options.showExternalNodes);
        setCheckboxValue(NODE_VIS_CB, _options.showNodeVisualizations);
        setCheckboxValue(BRANCH_VIS_CB, _options.showBranchVisualizations);
        setCheckboxValue(DYNAHIDE_CB, _options.dynahide);
        initializeVisualizationMenu();
        initializeSearchOptions();
    }


    function initializeVisualizationMenu() {
        if (true) {
            $('select#' + NODE_FILL_COLOR_SELECT_MENU).append($('<option>')
                .val(DEFAULT)
                .html("default")
            );
            $('select#' + NODE_BORDER_COLOR_SELECT_MENU).append($('<option>')
                .val(DEFAULT)
                .html("default")
            );
            $('select#' + NODE_BORDER_COLOR_SELECT_MENU).append($('<option>')
                .val(NONE)
                .html("none")
            );
            $('select#' + NODE_BORDER_COLOR_SELECT_MENU).append($('<option>')
                .val(SAME_AS_FILL)
                .html("same as fill")
            );

            $('select#' + NODE_SHAPE_SELECT_MENU).append($('<option>')
                .val(DEFAULT)
                .html("default")
            );
            $('select#' + NODE_SIZE_SELECT_MENU).append($('<option>')
                .val(DEFAULT)
                .html("default")
            );
            $('select#' + LABEL_COLOR_SELECT_MENU).append($('<option>')
                .val(DEFAULT)
                .html("default")
            );


            if (_visualizations) {
                if (_visualizations.labelColor) {
                    for (var key in _visualizations.labelColor) {
                        if (_visualizations.labelColor.hasOwnProperty(key)) {
                            $('select#' + LABEL_COLOR_SELECT_MENU).append($('<option>')
                                .val(key)
                                .html(key)
                            );
                        }
                    }
                }
                if (_visualizations.nodeShape) {
                    for (var key in _visualizations.nodeShape) {
                        if (_visualizations.nodeShape.hasOwnProperty(key)) {
                            $('select#' + NODE_SHAPE_SELECT_MENU).append($('<option>')
                                .val(key)
                                .html(key)
                            );
                        }
                    }
                }
                if (_visualizations.nodeFillColor) {
                    for (var key in _visualizations.nodeFillColor) {
                        if (_visualizations.nodeFillColor.hasOwnProperty(key)) {
                            $('select#' + NODE_FILL_COLOR_SELECT_MENU).append($('<option>')
                                .val(key)
                                .html(key)
                            );
                        }
                    }
                }
                if (_visualizations.nodeBorderColor) {
                    for (var key in _visualizations.nodeBorderColor) {
                        if (_visualizations.nodeBorderColor.hasOwnProperty(key)) {
                            $('select#' + NODE_BORDER_COLOR_SELECT_MENU).append($('<option>')
                                .val(key)
                                .html(key)
                            );
                        }
                    }
                }
                if (_visualizations.nodeSize) {
                    for (var key in _visualizations.nodeSize) {
                        if (_visualizations.nodeSize.hasOwnProperty(key)) {
                            $('select#' + NODE_SIZE_SELECT_MENU).append($('<option>')
                                .val(key)
                                .html(key)
                            );
                        }
                    }
                }
            }
        }
    }

    function initializeSearchOptions() {
        if (_options.searchUsesRegex === true) {
            _options.searchIsPartial = true;
        }
        if (_options.searchIsPartial === false) {
            _options.searchUsesRegex = false;
        }
        _options.searchNegateResult = false;
        setCheckboxValue(SEARCH_OPTIONS_CASE_SENSITIVE_CB, _options.searchIsCaseSensitive);
        setCheckboxValue(SEARCH_OPTIONS_COMPLETE_TERMS_ONLY_CB, !_options.searchIsPartial);
        setCheckboxValue(SEARCH_OPTIONS_REGEX_CB, _options.searchUsesRegex);
        setCheckboxValue(SEARCH_OPTIONS_NEGATE_RES_CB, _options.searchNegateResult);
    }


    function orderSubtree(n, order) {
        var changed = false;
        ord(n);
        if (!changed) {
            order = !order;
            ord(n);
        }
        function ord(n) {
            if (!n.children) {
                return;
            }
            var c = n.children;
            var l = c.length;
            if (l == 2) {
                var e0 = forester.calcSumOfAllExternalDescendants(c[0]);
                var e1 = forester.calcSumOfAllExternalDescendants(c[1]);
                if (e0 !== e1 && e0 < e1 === order) {
                    changed = true;
                    var c0 = c[0];
                    c[0] = c[1];
                    c[1] = c0;
                }
            }
            for (var i = 0; i < l; ++i) {
                ord(c[i]);
            }
        }
    }

    function cycleDisplay() {
        if (_options.phylogram && !_options.alignPhylogram) {
            _options.alignPhylogram = true;

        }
        else if (_options.phylogram && _options.alignPhylogram) {
            _options.phylogram = false;
            _options.alignPhylogram = false;
        }
        else if (!_options.phylogram && !_options.alignPhylogram) {
            _options.phylogram = true;
        }
        setDisplayTypeButtons();
        update(null, 0);
    }

    function setDisplayTypeButtons() {
        setRadioButtonValue(PHYLOGRAM_BUTTON, _options.phylogram && !_options.alignPhylogram);
        setRadioButtonValue(CLADOGRAM_BUTTON, !_options.phylogram && !_options.alignPhylogram);
        setRadioButtonValue(PHYLOGRAM_ALIGNED_BUTTON, _options.alignPhylogram && _options.phylogram);
        if (!_basicTreeProperties.branchLengths) {
            disableCheckbox('#' + PHYLOGRAM_BUTTON);
            disableCheckbox('#' + PHYLOGRAM_ALIGNED_BUTTON);
        }
    }

    function unCollapseAll(node) {
        forester.preOrderTraversal(node, function (n) {
            if (n._children) {
                n.children = n._children;
                n._children = null;
            }
            if (n[KEY_FOR_COLLAPSED_FEATURES_SPECIAL_LABEL]) {
                n[KEY_FOR_COLLAPSED_FEATURES_SPECIAL_LABEL] = undefined;
            }
        });
    }

    function decrDepthCollapseLevel() {
        _rank_collapse_level = -1;
        _branch_length_collapse_level = -1;
        resetCollapseByFeature();
        if (_root && _treeData && ( _external_nodes > 2 )) {
            if (_depth_collapse_level <= 1) {
                _depth_collapse_level = forester.calcMaxDepth(_root);
                unCollapseAll(_root);
            }
            else {
                --_depth_collapse_level;
                forester.collapseToDepth(_root, _depth_collapse_level);
            }
        }
        update(null, 0);
    }

    function incrDepthCollapseLevel() {
        _rank_collapse_level = -1;
        _branch_length_collapse_level = -1;
        resetCollapseByFeature();
        if (( _root && _treeData  ) && ( _external_nodes > 2 )) {
            var max = forester.calcMaxDepth(_root);
            if (_depth_collapse_level >= max) {
                _depth_collapse_level = 1;
            }
            else {
                unCollapseAll(_root);
                ++_depth_collapse_level;
            }
            forester.collapseToDepth(_root, _depth_collapse_level);
        }
        update(null, 0);
    }

    function decrBlCollapseLevel() {
        _rank_collapse_level = -1;
        _depth_collapse_level = -1;
        resetCollapseByFeature();
        if (_root && _treeData && ( _external_nodes > 2 )) {
            if (_branch_length_collapse_level <= _branch_length_collapse_data.min) {
                _branch_length_collapse_level = _branch_length_collapse_data.max;
            }
            _branch_length_collapse_level -= _branch_length_collapse_data.step;
            forester.collapseToBranchLength(_root, _branch_length_collapse_level);
        }
        update(null, 0);
    }

    function incrBlCollapseLevel() {
        _rank_collapse_level = -1;
        _depth_collapse_level = -1;
        resetCollapseByFeature();
        if (( _root && _treeData  ) && ( _external_nodes > 2 )) {
            if (_branch_length_collapse_level >= _branch_length_collapse_data.max
                || _branch_length_collapse_level < 0) {
                _branch_length_collapse_level = _branch_length_collapse_data.min;
            }
            _branch_length_collapse_level += _branch_length_collapse_data.step;
            if (_branch_length_collapse_level >= _branch_length_collapse_data.max) {
                unCollapseAll(_root);
            }
            else {
                forester.collapseToBranchLength(_root, _branch_length_collapse_level);
            }
        }
        update(null, 0);
    }

    function updateDepthCollapseDepthDisplay() {
        var v = obtainDepthCollapseDepthValue();
        $('#' + DEPTH_COLLAPSE_LABEL)
            .val(" " + v);
    }

    function updateBranchLengthCollapseBranchLengthDisplay() {
        var v = obtainBranchLengthCollapseBranchLengthValue();
        $('#' + BL_COLLAPSE_LABEL)
            .val(v);
    }

    function collapseByFeature(feature) {
        _rank_collapse_level = -1;
        _depth_collapse_level = -1;
        _branch_length_collapse_level = -1;
        if (feature === SPECIES_FEATURE) {
            collapseSpecificSubtrees(_root, null, KEY_FOR_COLLAPSED_FEATURES_SPECIAL_LABEL);
        }
        else if (feature === OFF_FEATURE) {
            unCollapseAll(_root)
        }
        else {
            collapseSpecificSubtrees(_root, feature, KEY_FOR_COLLAPSED_FEATURES_SPECIAL_LABEL);
        }
        update(null, 0);
    }


    function removeForCollapsedFeatureSpecialLabel(phy, keyForCollapsedFeatureSpecialLabel) {
        forester.preOrderTraversalAll(phy, function (n) {
            if (n[keyForCollapsedFeatureSpecialLabel]) {
                n[keyForCollapsedFeatureSpecialLabel] = undefined;
            }
        });

    }

    function collapseSpecificSubtrees(phy, nodePropertyRef, keyForCollapsedFeatureSpecialLabel) {
        unCollapseAll(phy);

        if (nodePropertyRef && nodePropertyRef.length > 0) {
            forester.preOrderTraversalAll(phy, function (n) {
                if (n.children && !n._children && ( n.children.length > 1 )) {
                    var pv = forester.getOneDistinctNodePropertyValue(n, nodePropertyRef);
                    if (pv != null) {
                        forester.collapse(n);
                        if (keyForCollapsedFeatureSpecialLabel) {
                            n[keyForCollapsedFeatureSpecialLabel] = '[' + nodePropertyRef + '] ' + pv;
                        }
                    }
                }
            });
        }
        else {
            forester.preOrderTraversalAll(phy, function (n) {
                if (n.children && !n._children && ( n.children.length > 1 )) {
                    var tv = forester.getOneDistinctTaxonomy(n);
                    if (tv != null) {
                        forester.collapse(n);
                        if (keyForCollapsedFeatureSpecialLabel) {
                            n[keyForCollapsedFeatureSpecialLabel] = tv;
                        }
                    }
                }
            });
        }

    }

    function resetCollapseByFeature() {
        var s = $('#' + COLLAPSE_BY_FEATURE_SELECT);
        if (s) {
            var f = s.val();
            if (f != OFF_FEATURE) {
                s.val(OFF_FEATURE);
                removeForCollapsedFeatureSpecialLabel(_root, KEY_FOR_COLLAPSED_FEATURES_SPECIAL_LABEL);
            }
        }
    }

    function updateButtonEnabledState() {
        if (_superTreeRoots && _superTreeRoots.length > 0) {
            enableButton($('#' + RETURN_TO_SUPERTREE_BUTTON));
        }
        else {
            disableButton($('#' + RETURN_TO_SUPERTREE_BUTTON));
        }

        if (forester.isHasCollapsedNodes(_root)) {
            enableButton($('#' + UNCOLLAPSE_ALL_BUTTON));
        }
        else {
            disableButton($('#' + UNCOLLAPSE_ALL_BUTTON));
        }
        var b = null;
        if (_foundNodes0 && !_searchBox0Empty) {
            b = $('#' + RESET_SEARCH_A_BTN);
            if (b) {
                b.prop('disabled', false);
                if (_foundNodes0.size < 1) {
                    b.css('background', '');
                    b.css('color', '');
                }
                else {
                    b.css('background', _options.found0ColorDefault);
                    b.css('color', WHITE);
                }
                var nd0 = _foundNodes0.size === 1 ? 'node' : 'nodes';
                b.prop('title', 'found ' + _foundNodes0.size + ' ' + nd0 + ' [click to ' + RESET_SEARCH_A_BTN_TOOLTIP + ']');
            }
        }
        else {
            b = $('#' + RESET_SEARCH_A_BTN);
            if (b) {
                b.prop('disabled', true);
                b.css('background', _settings.controlsBackgroundColor);
                b.css('color', '');
                b.prop('title', RESET_SEARCH_A_BTN_TOOLTIP);
            }
        }

        if (_foundNodes1 && !_searchBox1Empty) {
            b = $('#' + RESET_SEARCH_B_BTN);
            if (b) {
                b.prop('disabled', false);
                if (_foundNodes1.size < 1) {
                    b.css('background', '');
                    b.css('color', '');
                }
                else {
                    b.css('background', _options.found1ColorDefault);
                    b.css('color', WHITE);
                }
                var nd1 = _foundNodes1.size === 1 ? 'node' : 'nodes';
                b.prop('title', 'found ' + _foundNodes1.size + ' ' + nd1 + ' [click to ' + RESET_SEARCH_B_BTN_TOOLTIP + ']');
            }
        }
        else {
            b = $('#' + RESET_SEARCH_B_BTN);
            if (b) {
                b.prop('disabled', true);
                b.css('background', _settings.controlsBackgroundColor);
                b.css('color', '');
                b.prop('title', RESET_SEARCH_B_BTN_TOOLTIP);
            }
        }
    }

    function updateLegendButtonEnabledState() {
        var b = $('#' + LEGENDS_SHOW_BTN);
        if (b) {
            if (_showLegends) {
                b.css('background', COLOR_FOR_ACTIVE_ELEMENTS);
                b.css('color', WHITE);
            }
            else {
                b.css('background', '');
                b.css('color', '');
            }
        }
        if (_showLegends && ( _legendColorScales[LEGEND_LABEL_COLOR] ||
            (_options.showNodeVisualizations && ( _legendColorScales[LEGEND_NODE_FILL_COLOR] ||
            _legendColorScales[LEGEND_NODE_BORDER_COLOR] ||
            _legendShapeScales[LEGEND_NODE_SHAPE] ||
            _legendSizeScales[LEGEND_NODE_SIZE])))) {
            enableButton($('#' + LEGENDS_HORIZ_VERT_BTN));
            enableButton($('#' + LEGENDS_MOVE_UP_BTN));
            enableButton($('#' + LEGENDS_MOVE_DOWN_BTN));
            enableButton($('#' + LEGENDS_MOVE_LEFT_BTN));
            enableButton($('#' + LEGENDS_MOVE_RIGHT_BTN));
            enableButton($('#' + LEGENDS_RESET_BTN));
        }
        else {
            disableButton($('#' + LEGENDS_HORIZ_VERT_BTN));
            disableButton($('#' + LEGENDS_MOVE_UP_BTN));
            disableButton($('#' + LEGENDS_MOVE_DOWN_BTN));
            disableButton($('#' + LEGENDS_MOVE_LEFT_BTN));
            disableButton($('#' + LEGENDS_MOVE_RIGHT_BTN));
            disableButton($('#' + LEGENDS_RESET_BTN));
        }
    }

    function disableCheckbox(cb) {
        if (cb) {
            var b = $(cb);
            if (b) {
                b.checkboxradio({
                    disabled: true
                });
            }
        }
    }

    function disableButton(b) {
        if (b) {
            b.prop('disabled', true);
            b.css('background', _settings.controlsBackgroundColor);
        }
    }

    function enableButton(b) {
        if (b) {
            b.prop('disabled', false);
            b.css('background', '');
        }
    }

    function obtainDepthCollapseDepthValue() {
        if (!(_treeData && _root)) {
            return "";
        }
        if (_external_nodes < 3) {
            return "off";
        }
        else if (_depth_collapse_level < 0) {
            _depth_collapse_level = forester.calcMaxDepth(_root);
            return "off";
        }
        else if (_depth_collapse_level == forester.calcMaxDepth(_root)) {
            return "off";
        }
        return _depth_collapse_level;
    }

    function obtainBranchLengthCollapseBranchLengthValue() {
        if (!(_treeData && _root)) {
            return "";
        }
        if (!_branch_length_collapse_data.min) {
            resetBranchLengthCollapseValue();
        }

        if (_external_nodes < 3) {
            return "off";
        }
        else if (_branch_length_collapse_level <= _branch_length_collapse_data.min) {
            return "off";
        }
        else if (_branch_length_collapse_level >= _branch_length_collapse_data.max) {
            return "off";
        }
        return _branch_length_collapse_level;
    }


    function resetDepthCollapseDepthValue() {
        _depth_collapse_level = -1;
    }

    function resetRankCollapseRankValue() {
        _rank_collapse_level = -1;
    }

    function resetBranchLengthCollapseValue() {
        _branch_length_collapse_level = -1;
        _branch_length_collapse_data.min = Number.MAX_VALUE;
        _branch_length_collapse_data.max = 0;

        if (_root) {
            forester.removeMaxBranchLength(_root);
            var stats = forester.calcBranchLengthSimpleStatistics(_root);
            _branch_length_collapse_data.min = stats.min;
            _branch_length_collapse_data.max = stats.max;
            _branch_length_collapse_data.max = 0.25 * ( (3 * _branch_length_collapse_data.max) + _branch_length_collapse_data.min );
            var x = stats.n < 200 ? ( stats.n / 4) : 50;
            _branch_length_collapse_data.step = (_branch_length_collapse_data.max - _branch_length_collapse_data.min) / x;

        }
    }

    function getTreeAsSvg() {
        var container = _id.replace('#', '');
        var wrapper = document.getElementById(container);
        var svg = wrapper.querySelector('svg');
        var svgTree = null;
        if (typeof window.XMLSerializer !== 'undefined') {
            svgTree = (new XMLSerializer()).serializeToString(svg);
        }
        else if (typeof svg.xml !== 'undefined') {
            svgTree = svg.xml;
        }
        return svgTree;
    }

    function downloadTree(format) {
        if (format === PNG_EXPORT_FORMAT) {
            downloadAsPng()
        }
        else if (format === SVG_EXPORT_FORMAT) {
            downloadAsSVG();
        }
        else if (format === NH_EXPORT_FORMAT) {
            downloadAsNH();
        }
        else if (format === PHYLOXML_EXPORT_FORMAT) {
            downloadAsPhyloXml();
        }
        else if (format === PDF_EXPORT_FORMAT) {
            downloadAsPdf();
        }
    }

    function downloadAsPhyloXml() {
        var x = phyloXml.toPhyloXML(_root, 9);
        saveAs(new Blob([x], {type: "application/xml"}), _options.nameForPhyloXmlDownload);
    }

    function downloadAsNH() {
        var nh = forester.toNewHampshire(_root, 9, _settings.nhExportReplaceIllegalChars, _settings.nhExportWriteConfidences);
        saveAs(new Blob([nh], {type: "application/txt"}), _options.nameForNhDownload);
    }

    function downloadAsSVG() {
        var svg = getTreeAsSvg();
        saveAs(new Blob([decodeURIComponent(encodeURIComponent(svg))], {type: "application/svg+xml"}), _options.nameForSvgDownload);
    }

    function downloadAsPdf() {
    }

    function downloadAsPng() {
        var svg = getTreeAsSvg();
        var canvas = document.createElement("canvas");
        canvg(canvas, svg);
        canvas.toBlob(function (blob) {
            saveAs(blob, _options.nameForPngDownload);
        });
    }

    // --------------------------------------------------------------
    // Convenience methods for loading tree on HTML page
    // --------------------------------------------------------------

    /**
     * Convenience method for loading tree on HTML page
     *
     * @param location
     * @param data
     * @param newHamphshireConfidenceValuesInBrackets
     * @param newHamphshireConfidenceValuesAsInternalNames
     * @returns {*}
     */
    archaeopteryx.parseTree = function (location,
                                        data,
                                        newHamphshireConfidenceValuesInBrackets,
                                        newHamphshireConfidenceValuesAsInternalNames) {
        if (newHamphshireConfidenceValuesInBrackets == undefined) {
            newHamphshireConfidenceValuesInBrackets = true;
        }
        if (newHamphshireConfidenceValuesAsInternalNames == undefined) {
            newHamphshireConfidenceValuesAsInternalNames = false;
        }
        var tree = null;
        if (location.substr(-3, 3).toLowerCase() === 'xml') {
            tree = archaeopteryx.parsePhyloXML(data);
        }
        else {
            tree = archaeopteryx.parseNewHampshire(data,
                newHamphshireConfidenceValuesInBrackets,
                newHamphshireConfidenceValuesAsInternalNames);
        }
        return tree;
    };

    /**
     *
     *
     *
     * @param label
     * @param location
     * @param data
     * @param options
     * @param settings
     * @param newHamphshireConfidenceValuesInBrackets
     * @param newHamphshireConfidenceValuesAsInternalNames
     */
    archaeopteryx.launchArchaeopteryx = function (label,
                                                  location,
                                                  data,
                                                  options,
                                                  settings,
                                                  newHamphshireConfidenceValuesInBrackets,
                                                  newHamphshireConfidenceValuesAsInternalNames,
                                                  nodeVisualizations) {
        var tree = null;
        try {
            tree = archaeopteryx.parseTree(location,
                data,
                newHamphshireConfidenceValuesInBrackets,
                newHamphshireConfidenceValuesAsInternalNames);
        }
        catch (e) {
            alert('error while parsing tree: ' + e);
        }
        if (tree) {
            try {
                archaeopteryx.launch(label, tree, options, settings, nodeVisualizations);
            }
            catch (e) {
                alert('error while launching archaeopteryx: ' + e);
            }
        }
    };


// --------------------------------------------------------------
// For exporting
// --------------------------------------------------------------
    if (typeof module !== 'undefined' && module.exports && !global.xmldocAssumeBrowser)
        module.exports.archaeopteryx = archaeopteryx;
    else if (typeof window !== "undefined")
        window.archaeopteryx = archaeopteryx;
    else
        this.archaeopteryx = archaeopteryx;
})
();