<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="javascript:void(0);">
        <div class="sidebar-brand-icon">
            <!-- <img src="#"> -->
        </div>
        <div class="sidebar-brand-text mx-3">CMS</div>
    </a>
    <hr class="sidebar-divider m-1" />
    <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard </span>
        </a>
    </li>

    @if((Auth::user()->user_type == 'SuperAdmin') )



    <hr class="sidebar-divider" />
    <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/user-list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Players List </span>
        </a>
    </li>

    <hr class="sidebar-divider" />
    <li class="nav-item">
        <a class="nav-link" href="{{url('admin/user-lottery-result-amount')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Player Result </span>
        </a>
    </li>



    <hr class="sidebar-divider" />
    <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/deposit_history_list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Player Deposit Request</span>
        </a>
    </li>

    <hr class="sidebar-divider" />
    <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/withdraw-history-list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Player Withdraw Request</span>
        </a>
    </li>

    <div style="background-color: #bb0259; height: 10px; margin-top: 20px;"></div>
    
   
   

    <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/game-category-rat-list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Lottery Cat. or Rate</span>
        </a>
    </li>

    

    <!--  <hr class="sidebar-divider" />

    <li class="nav-item">
        <a class="nav-link" href="{{url('admin/add-new-lottery')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Add New Lottery</span>
        </a>
    </li>
 -->
    <hr class="sidebar-divider" />
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/wining-lottery-result')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Winning Lottery</span>
        </a>
    </li>

   
    
    <hr class="sidebar-divider" />
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/open-close-lottery-list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>All Lottery List </span>
        </a>
    </li>


    <!-- <hr class="sidebar-divider" />
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/lottery-result-decleare')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Player Result Declare</span>
        </a>
    </li> -->

    

    <hr class="sidebar-divider " />
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/upload-result-excel')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Upload Lottery Result</span>
        </a>
    </li> 

    <hr class="sidebar-divider" />
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/lottery-result-history')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Lottery Result History</span>
        </a>
    </li>

     <div style="background-color: #bb0259; height: 10px; margin-top: 20px;"></div>

      <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/search-market-report')}}">
            <i class="fas fa-skull-crossbones"></i>
            <span>Market Report</span>
        </a>
    </li> 
    <hr class="sidebar-divider" />
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/search-product-report')}}">
            <i class="fas fa-skull-crossbones"></i>
            <span>Agent Report</span>
        </a>
    </li>




    <div style="background-color: #bb0259; height: 10px; margin-top: 20px;"></div>

    
    
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/add_deposit_acc')}}">
            <i class="fas fa-skull-crossbones"></i>
            <span>Add Deposit A/C Detail</span>
        </a>
    </li>
    <hr class="sidebar-divider" />
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/deposit_acc_list')}}">
            <i class="fas fa-skull-crossbones"></i>
            <span>Deposit A/C Detail List</span>
        </a>
    </li>

   
    <hr class="sidebar-divider" />
     <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/dashboard-user-list')}}">
            <i class="fas fa-skull-crossbones"></i>
            <span>User Type & Access</span>
        </a>
    </li>

    <div style="background-color: #bb0259; height: 10px; margin-top: 20px;"></div>
    
   
   

    <!-- <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/dashboard-user-support')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Add Support Detail</span>
        </a>
    </li> -->

    <hr class="sidebar-divider" />
     <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/dashboard-user-support-list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Support Detail List</span>
        </a>
    </li>
    
     @endif

     @if((Auth::user()->user_type == 'Admin') )



    <hr class="sidebar-divider" />
    <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/user-list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Players List </span>
        </a>
    </li>

    <hr class="sidebar-divider" />
    <li class="nav-item">
        <a class="nav-link" href="{{url('admin/user-lottery-result-amount')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Player Result </span>
        </a>
    </li>



    <hr class="sidebar-divider" />
    <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/deposit_history_list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Player Deposit Request</span>
        </a>
    </li>

    <hr class="sidebar-divider" />
    <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/withdraw-history-list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Player Withdraw Request</span>
        </a>
    </li>

    <div style="background-color: #bb0259; height: 10px; margin-top: 20px;"></div>
    
   

    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/wining-lottery-result')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Winning Lottery</span>
        </a>
    </li>

   
    
    <hr class="sidebar-divider" />
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/open-close-lottery-list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>All Lottery List </span>
        </a>
    </li>

    
    <hr class="sidebar-divider" />
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/lottery-result-history')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Lottery Result History</span>
        </a>
    </li>

     <div style="background-color: #bb0259; height: 10px; margin-top: 20px;"></div>

      <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/search-market-report')}}">
            <i class="fas fa-skull-crossbones"></i>
            <span>Market Report</span>
        </a>
    </li> 
    <hr class="sidebar-divider" />
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/search-product-report')}}">
            <i class="fas fa-skull-crossbones"></i>
            <span>Agent Report</span>
        </a>
    </li>

    <div style="background-color: #bb0259; height: 10px; margin-top: 20px;"></div>


    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/add_deposit_acc')}}">
            <i class="fas fa-skull-crossbones"></i>
            <span>Add Deposit A/C Detail</span>
        </a>
    </li>
    <hr class="sidebar-divider" />
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/deposit_acc_list')}}">
            <i class="fas fa-skull-crossbones"></i>
            <span>Deposit A/C Detail List</span>
        </a>
    </li>


    <hr class="sidebar-divider" />
     <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/dashboard-user-support-list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Support Detail List</span>
        </a>
    </li>
    
     @endif



     @if((Auth::user()->user_type == 'Agent') )



    
    <hr class="sidebar-divider" />
    <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/user-list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Player List </span>
        </a>
    </li>

    <hr class="sidebar-divider" />
    <li class="nav-item">
        <a class="nav-link" href="{{url('admin/user-lottery-result-amount')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Player Result</span>
        </a>
    </li>



    <hr class="sidebar-divider" />
    <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/deposit_history_list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Player Deposit Request</span>
        </a>
    </li>

    <hr class="sidebar-divider" />
    <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/withdraw-history-list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Player Withdraw Request</span>
        </a>
    </li>

    <div style="background-color: #bb0259; height: 10px; margin-top: 20px;"></div>
    

   
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/open-close-lottery-list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>All Lottery List</span>
        </a>
    </li>


    

    <hr class="sidebar-divider" />
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/lottery-result-history')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Lottery Result History</span>
        </a>
    </li>

     <div style="background-color: #bb0259; height: 10px; margin-top: 20px;"></div>

    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/add_deposit_acc')}}">
            <i class="fas fa-skull-crossbones"></i>
            <span>Add Deposit A/C Detail</span>
        </a>
    </li>
    <hr class="sidebar-divider" />
    
    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/deposit_acc_list')}}">
            <i class="fas fa-skull-crossbones"></i>
            <span>Deposit A/C Detail List</span>
        </a>
    </li>
    <div style="background-color: #bb0259; height: 10px; margin-top: 20px;"></div>

    <li class="nav-item active">
        <a class="nav-link" href="{{url('admin/search-product-report')}}">
            <i class="fas fa-skull-crossbones"></i>
            <span>Agent Report</span>
        </a>
    </li>


    <div style="background-color: #bb0259; height: 10px; margin-top: 20px;"></div>
    <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/dashboard-user-support')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Add Support Detail</span>
        </a>
    </li>

    <hr class="sidebar-divider" />
     <li class="nav-item ">
        <a class="nav-link" href="{{url('admin/dashboard-user-support-list')}}">
            <i class="fas fa-fw fa-star"></i>
            <span>Support Detail List</span>
        </a>
    </li>


    @endif

   

     

  
</ul>
