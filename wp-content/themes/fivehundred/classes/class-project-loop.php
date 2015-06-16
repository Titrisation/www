<?php
/**
 * Class for Project Loop
 */
class Fh_Project_Loop {
	private $project_id;
	private $post_id;
	private $hDeck;
	// For the loop
	private $project_count;
	private $current_project;
	private $projects;
	private $project;
	private $summary;
	private $in_the_loop;

	function __construct() {
		add_filter('idcf_function_markup_echo', array($this, 'idcf_output_markup_fivehundred_functions'), 10, 2);
	}

	public function init() {
		$this->project_count = 0;
		unset($this->projects);
		unset($this->summary);
		unset($this->project);
		$this->in_the_loop = false;
		$this->current_project = -1;
	}

	/********************************************************************************************************
	 *  Functions for using in hDeck or featured projects
	 ********************************************************************************************************/

	/**
	 * Function for getting all projects and adding into loop
	 */
	public function idcf_projects() {
		$this->projects = ID_Project::get_all_projects();
	}

	/**
	 * Function to get hDeck depending on the arguments coming
	 */
	public function idcf_get_hdeck() {
		// see if hDeck is coming in arguments, if yes, don't need to get it
		if (empty($this->hDeck)) {
			$new_hdeck = new Deck($this->project_id);
			if (method_exists($new_hdeck, 'hDeck')) {
				$this->hDeck = $new_hdeck->hDeck();
			}
			else {
				// If this->post_id is not coming in arguments, get it using this->project_id
				if (empty($this->post_id)) {
					$project = new ID_Project($this->project_id);
					$this->post_id = $project->get_project_postid();
				}
				$this->hDeck = the_project_hDeck($this->post_id);
			}
		}
		return $this->hDeck;
	}

	/**
	 * Filter to decide whether to echo or return markup
	 */
	public function idcf_output_markup_fivehundred_functions($markup, $is_echo) {
		if (!empty($is_echo) && $is_echo) {
			echo $markup;
			return '';
		}

		return $markup;
	}

	/**
	 * Function for getting the ID for the project
	 */
	public function the_ID($echo = true) {
		return apply_filters('idcf_function_markup_echo', (string) $this->project_id, $echo);
	}

	/**
	 * Function to display project title by default in <h3> tag
	 */
	public function idcf_project_title($echo = true) {
		$markup = '<h3>'.$this->summary->name.'</h3>';
		return apply_filters('idcf_function_markup_echo', $markup, $echo);
	}

	/**
	 * Function to display project description by default inside <p> tag
	 */
	public function idcf_project_short_description($echo = true) {
		$markup = '<p>'.$this->summary->short_description.'</p>';
		return apply_filters('idcf_function_markup_echo', $markup, $echo);
	}

	/**
	 * Function to get project goal html markup
	 */
	public function idcf_get_project_goal($featured = false) {
		if ($featured) {
			$markup = '<div class="featured-item">
							<strong>'.__('Goal',  'fivehundred').': </strong><span>'.$this->hDeck->goal.'</span>
						</div>';
		} else {
			$markup = '<div class="ign-product-goal" style="clear: both;">
							<div class="ign-goal">'.__('Goal', 'fivehundred').'</div> <strong>'.$this->hDeck->goal.' </strong>
						</div>';
		}
		return $markup;
	}

	/**
	 * Function to get project days left html markup
	 */
	public function idcf_project_days_left($featured = false) {
		if ($featured) {
			$markup = '<div class="featured-item">
							<strong>'.__('Days Left',  'fivehundred').': </strong><span>'.$this->hDeck->days_left.'</span>
						</div>';
		} else {
			$markup = '<div class="ign-days-left">
							<strong>'.$this->hDeck->days_left.' '.__('Days Left', 'fivehundred').'</strong>
						</div>';
		}
		return $markup;
	}

	/**
	 * Function to get project progress bar html
	 */
	public function idcf_project_progress_bar() {
		$markup = '<div class="ign-progress-wrapper" style="clear: both;">
						<div class="ign-progress-percentage">
										'.$this->hDeck->percentage.'%
						</div> <!-- end progress-percentage -->
						<div style="width: '.$this->hDeck->percentage.'%" class="ign-progress-bar">
						
						</div><!-- end progress bar -->
					</div>';
		return $markup;
	}

	/**
	 * Function to get project funds raised html
	 */
	public function idcf_project_raised_fund($featured = false) {
		if ($featured) {
			$markup = '<div class="featured-item">
							<strong>'.__('Raised',  'fivehundred').': </strong><span>'.$this->hDeck->total.'</span>
						</div>';
		} else {
			$markup = '<div class="ign-progress-raised">
							<strong>'.$this->hDeck->total.'</strong>
							<div class="ign-raised">
								'.__('Raised', 'fivehundred').'
							</div>
						</div>';
		}
		return $markup;
	}

	/**
	 * Function to get project supporters count html
	 */
	public function idcf_project_total_pledgers($featured = false) {
		if ($featured) {
			$markup = '<div class="featured-item">
							<strong>'.__('Supporters',  'fivehundred').': </strong><span>'.$this->hDeck->pledgers.'</span>
						</div>';
		} else {
			$markup = '<div class="ign-product-supporters" style="clear: both;">
							<strong>'.$this->hDeck->pledges.'</strong>
							<div class="ign-supporters">
								'.__('Supporters', 'fivehundred').'
							</div>
						</div>';
		}
		return $markup;
	}

	/**
	 * Function to get project Support Button html
	 */
	public function idcf_project_support_button() {
		// Markup for support now button
		$markup = '<div class="ign-supportnow" data-projectid="'.$this->project_id.'">';
		if ($this->hDeck->end_type == 'closed' && $this->hDeck->days_left <= 0) {
			$markup .= '<a href="" class="">'.__('Project Closed', 'fivehundred').'</a>';
		} else {
			if (function_exists('is_id_licensed') && is_id_licensed()) {
				if (empty($permalinks) || $permalinks == '') {
					$markup .= 
						'<a href="'.the_permalink().'&purchaseform=500&amp;prodid='.(isset($this->project_id) ? $this->project_id : '').'">'.__('Support Now', 'fivehundred').'</a>';
				}
				else {
					$markup .= 
						'<a href="'.the_permalink().'?purchaseform=500&amp;prodid='.(isset($this->project_id) ? $this->project_id : '').'">'.__('Support Now', 'fivehundred').'</a>';
				}
			}
		}
		$markup .= '</div>';
		return $markup;
	}

	/**
	 * Function to get Learn more button for featured project
	 */
	public function idcf_featured_project_learn_button() {
		$markup = '<a class="featured-button" href="'.get_permalink($this->post_id).'">
						<span>'.__('Learn More', 'fivehundred').'</span>
					</a>';
		return $markup;
	}

	/**
	 * Function to get project end date html markup
	 */
	public function idcf_project_end_date() {
		// Markup for end date
		$markup = '	<div class="ign-product-proposed-end"><span>'.__('Project Ends', 'fivehundred').':</span>
						<div id="ign-widget-date">
							<div id="ign-widget-month">'.__($this->hDeck->month, 'fivehundred').'</div>
							<div id="ign-widget-day">'.__($this->hDeck->day, 'fivehundred').'</div>
							<div id="ign-widget-year">'.__($this->hDeck->year, 'fivehundred').'</div>
						</div>
						<div class="clear"></div>
					</div>';
		return $markup;
	}

	/**
	 * Function to give markup when hDeck is not set
	 */
	public function idcf_no_hdeck_set($echo = false) {
		$markup = '<div id="ign-hDeck-wrapper">
						<div id="ign-hdeck-wrapperbg">
							<div id="ign-hDeck-header">
								<div id="ign-hDeck-left">
								</div>
								<div id="ign-hDeck-right">
									<div class="internal">
									</div>
								</div>
								<div class="clear"></div>
							</div>
						</div>
					</div>';
		return apply_filters('idcf_function_markup_echo', $markup, $echo);
	}

	/**
	 * Function to loop through projects
	 */
	public function idcf_have_projects() {
		// If current project + 1 is less than project count, then return true. This will keep the loop moving
		if (isset($this->project_count) && $this->project_count > 0 && ($this->current_project + 1) < $this->project_count) {
			return true;
		}
		else if (isset($this->project_count) && $this->project_count > 0 && ($this->current_project) == $this->project_count) {
			$this->current_project = -1;
			// Reset $this->project
			if ($this->project_count > 0) {
				$this->project = $this->projects[0];
			}
		}

		$this->in_the_loop = false;
		return false;
	}

	/**
	 * Function to get the project into hDeck
	 */
	public function idcf_the_project() {
		$this->in_the_loop = true;
		$this->project = $this->idcf_next_project();
	}

	/**
	 * Function for getting next project in the loop
	 */
	public function idcf_next_project() {
		$this->current_project ++;

		$project = $this->projects[$this->current_project];
		// Getting post_id of project using ID_Project class
		$id_project = new ID_Project($project->id);
		$this->post_id = $id_project->get_project_postid();
		$this->project_id = $project->id;

		$this->hDeck = the_project_hDeck($this->post_id);
		$this->summary = the_project_summary($this->post_id);

		return $project;
	}

	/**
	 * Function for setting this->projects array to global project
	 */
	public function idcf_set_projects() {
		global $project, $post;
		// Adding the project to array if it's not empty
		if (!empty($project)) {
			$this->projects = array();
			array_push( $this->projects, $project );
			$this->post_id = $post->ID;
			$this->idcf_the_project();
		}
	}

	/**
	 * Function for getting the content of post of the ID project
	 */
	public function idcf_the_content() {
		$content = the_project_content($this->post_id);
		return $content;
	}
}

$project_loop = new Fh_Project_Loop();
$project_loop->init();
$project = null;
?>