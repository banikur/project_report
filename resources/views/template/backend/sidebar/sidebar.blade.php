<!-- #NAVIGATION -->
<!-- Left panel : Navigation area -->
<!-- Note: This width of the aside area can be adjusted through LESS variables -->
<aside id="left-panel">




    <nav>
        <!--
        NOTE: Notice the gaps after each icon usage <i></i>..
        Please note that these links work a bit different than
        traditional href="" links. See documentation for details.
        -->
        <ul>
        <br/><br/><br/>
        </ul>
        <ul>
        @if(Auth::guard('koki')->check())
            <li>
                <a href="{{url('/Koki/dashboard')}}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
            </li>
            <li>
                <a href="{{url('/Koki/list-order')}}" title="Dashboard"><i class="fa fa-lg fa-fw fa-tasks"></i> <span class="menu-item-parent">List Order</span></a>
            </li>
            <li>
                <a href="{{url('/Koki/data-menu')}}" title="Dashboard"><i class="fa fa-lg fa-fw fa-book"></i> <span class="menu-item-parent">Data Menu</span></a>
            </li>
            <li>
                <a href="{{url('/Koki/permintaan-pembelian')}}" title="Dashboard"><i class="fa fa-lg fa-fw fa-fax"></i> <span class="menu-item-parent">Permintaan Pembelian</span></a>
            </li>
        @elseif(Auth::guard('manager')->check())
            <li>
                <a href="{{url('/Manager/dashboard')}}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
            </li>
            <li>
                <a href="{{url('/Manager/employee')}}" title="Employee"><i class="fa fa-lg fa-fw fa-people"></i> <span class="menu-item-parent">Employee</span></a>
            </li>
        @elseif(Auth::guard('purchasing')->check())
            <li>
                <a href="{{url('/Purchasing/master-dashboard')}}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
            </li>
            <li>
                <a href="{{url('/Purchasing/permintaan-pembelian')}}" title="Permintaan Pembelian"><i class="fa fa-lg fa-fw fa-cart-plus"></i></i> <span class="menu-item-parent">Permintaan Pembelian</span></a>
            </li>
            <li>
                <a href="{{url('/Purchasing/permintaan_barang_koki')}}" title="Permintaan Barang"><i class="fa fa-lg fa-fw fa-cart-arrow-down"></i></i> <span class="menu-item-parent">Permintaan Barang</span></a>
            </li>
            <li>
                <a href="{{url('/Purchasing/purchasing-order')}}" title="Purchasing Order"><i class="fa fa-lg fa-fw fa-money"></i></i> <span class="menu-item-parent">Purchasing Order</span></a>
            </li>
            <li>
                <a href="{{url('/Purchasing/surat-terima_barang')}}" title="Surat Terima Barang"><i class="fa fa-lg fa-fw fa-clipboard"></i> <span class="menu-item-parent">Surat Terima Barang</span></a>
            </li>
            <li>
                <a href="{{url('/Purchasing/payment-voucher')}}" title="Payment Voucher"><i class="fa fa-lg fa-fw fa-fax"></i> <span class="menu-item-parent">Payment Voucher</span></a>
            </li>
            <li>
                <a href="{{url('/Purchasing/master-barang')}}" title="Master Barang"><i class="fa fa-lg fa-fw fa-tasks"></i> <span class="menu-item-parent">Master Barang</span></a>
            </li>
            <li>
                <a href="{{url('/Purchasing/supplier')}}" title="Supplier"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Supplier</span></a>
            </li>
            <li>
                <a href="{{url('/Purchasing/cetak_pv')}}" title="Purchasing Voucher Cetak"><i class="fa fa-lg fa-fw fa-print"></i> <span class="menu-item-parent">Cetak PV</span></a>
            </li>
        @endif
            <!-- <li>
                <a href="#"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Profile Perusahaan</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-lg fa-fw fa-tasks"></i> <span class="menu-item-parent">Input Karyawan</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-lg fa-fw fa-book"></i> <span class="menu-item-parent">Golongan Gaji</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-lg fa-fw fa-pencil"></i> <span class="menu-item-parent">Buat Slip Gaji</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Pengaturan</span></a>
            </li> -->
            
        </ul>


    </nav>



</aside>
<!-- END NAVIGATION -->
