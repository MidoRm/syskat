<?php 
/**
 * @version 1.0
 * @package DJ-Tabs
 * @copyright Copyright (C) 2013 DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Piotr Dobrakowski - piotr.dobrakowski@design-joomla.eu
 *
 * DJ-Tabs is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Tabs is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Tabs. If not, see <http://www.gnu.org/licenses/>.
 *
 */

defined('_JEXEC') or die('Restricted access');
 
if(version_compare(JVERSION, '3.0', '>=')) JHtml::_('formbehavior.chosen', 'select');
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= true; //$user->authorise('core.edit.state', 'com_contact.category');

$saveOrder  = $listOrder == 'a.ordering';

?>



<form action="<?php echo JRoute::_('index.php?option=com_djtabs&view=items'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar" class="btn-toolbar">
		<div class="filter-search fltlft btn-group navbar-search pull-left">
			<label class="hidden filter-search-lbl help-inline" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input class="search-query input-small" type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" 
			title="<?php echo JText::_('COM_DJTABS_SEARCH_IN_TITLE'); ?>" placeholder="<?php echo JText::_('COM_DJTABS_SEARCH_IN_TITLE'); ?>" />
		</div>
		<div class="filter-search fltlft navbar-search btn-group pull-left">
			<button class="btn" type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button class="btn" type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		
		<div class="filter-select fltrt pull-right">
			<select name="filter_published" class="inputbox input-medium" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', array(JHtml::_('select.option', '1', 'JPUBLISHED'),JHtml::_('select.option', '0', 'JUNPUBLISHED')), 'value', 'text', $this->state->get('filter.published'), true);?>
			</select>
			<select name="filter_group" class="inputbox input-medium" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_DJTABS_SELECT_GROUP');?></option>
				<?php echo JHtml::_('select.options', $this->group_options, 'value', 'text', $this->state->get('filter.group'));?>
			</select>
		</div>
	</fieldset>
	<div class="clr"> </div>
	
	<table class="adminlist table table-striped">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
				</th>
				<?php $version = new JVersion;
				if (version_compare($version->getShortVersion(), '3.0.0', '>=')):?>
				<th width="1%"></th>
				<?php endif; ?>
				<th>
                    <?php echo JHtml::_('grid.sort',  'JGLOBAL_TITLE', 'a.name', $listDirn, $listOrder); ?>
                </th>         
                <th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_DJTABS_GROUP', 'group_name',   $listDirn, $listOrder); ?>
				</th>   
				 <th width="10%">
                    <?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.published',   $listDirn, $listOrder); ?>
                </th>
				<th width="12%">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering',  $listDirn, $listOrder); ?>
					<?php if ($canOrder && $saveOrder) :?>
						<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'items.saveorder'); ?>
					<?php endif; ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id',   $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php 
		$n = count($this->items);
		foreach ($this->items as $i => $item) :
			$ordering	= ($listOrder == 'a.ordering');
			$canCreate	= true; //$user->authorise('core.create',		'com_contact.category.'.$item->group_id);
			$canEdit	= true; //$user->authorise('core.edit',			'com_contact.category.'.$item->group_id);
			$canCheckin	= true; //$user->authorise('core.manage',		'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
			$canEditOwn	= true; //$user->authorise('core.edit.own',		'com_contact.category.'.$item->group_id) && $item->created_by == $userId;
			$canChange	= true; //$user->authorise('core.edit.state',	'com_contact.category.'.$item->group_id) && $canCheckin;

			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
				<?php $version = new JVersion;
				if (version_compare($version->getShortVersion(), '3.0.0', '>=')):?>
				<td align="center">
					<?php 
					if($item->type == '1'){
						echo '<i style="color:#CECECE" class="icon-list"></i>';
					}
					elseif($item->type == '2'){
						echo '<i style="color:#CECECE" class="icon-file-2"></i>';
					}
					elseif($item->type == '3'){
						echo '<i style="color:#CECECE" class="icon-puzzle"></i>';
					}
					elseif($item->type == '4'){
						echo '<i style="color:#CECECE" class="icon-play-2"></i>';
					}
					?>
				</td>
				<?php endif; ?>
				<td>
	
					<?php if ($canEdit || $canEditOwn) : ?>
						<a href="<?php echo JRoute::_('index.php?option=com_djtabs&task=item.edit&id='.(int) $item->id); ?>">
							<?php echo $this->escape($item->name); ?></a>
					<?php else : ?>
						<?php echo $this->escape($item->name); ?>
					<?php endif; ?>
					<p class="smallsub">
				</td>
				<td align="center">
					<?php echo (empty($item->group_name) == false) ? $item->group_name : '<span style="color: red">'.JText::_('COM_DJTABS_UNASSIGNED').'</span>'; ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'items.', true, 'cb'	); ?>
				</td>
				<td class="order">
					<?php if ($canChange) : ?>
						<?php if ($saveOrder) :?>
							<?php if ($listDirn == 'asc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, ($item->group_id == @$this->items[$i-1]->group_id),'items.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $n, ($item->group_id == @$this->items[$i+1]->group_id), 'items.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							<?php elseif ($listDirn == 'desc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, ($item->group_id == @$this->items[$i-1]->group_id),'items.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $n, ($item->group_id == @$this->items[$i+1]->group_id), 'items.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							<?php endif; ?>
						<?php endif; ?>
						<?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
					<?php else : ?>
						<?php echo $item->ordering; ?>
					<?php endif; ?>
				</td>
				<td align="center">
					<?php echo $item->id; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>


<?php echo DJTABSFOOTER; ?>