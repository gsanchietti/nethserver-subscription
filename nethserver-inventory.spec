Summary: NethServer Inventory
Name: nethserver-inventory
Version: 2.0.8
Release: 1%{?dist}
License: GPL
Source0: %{name}-%{version}.tar.gz
BuildArch: noarch

Requires: puppet-agent
Requires: nethserver-subscription
BuildRequires: nethserver-devtools

%description
Inventory based on facter.

%prep
%setup -q

%build
perl createlinks

%install
rm -rf %{buildroot}
(cd root ; find . -depth -print | cpio -dump %{buildroot})
%{genfilelist} %{buildroot} > %{name}-%{version}-%{release}-filelist


%files -f %{name}-%{version}-%{release}-filelist
%defattr(-,root,root)
%dir %{_nseventsdir}/%{name}-update
%doc LICENSE

%changelog
* Mon Feb 19 2018 Davide Principi <davide.principi@nethesis.it> - 2.0.8-1
- Collect templates_custom and p3scan usage data

* Wed Jan 10 2018 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 2.0.7-1
- NethCTI 3: add profiling component - Nethesis/dev#5271

* Fri Jun 30 2017 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 2.0.6-1
- KPI: count VOIP devices - Nethesis/dev#5166 Nethesis/dev#5145
- KPI: count MAC addresses - Nethesis/dev#5146

* Wed Apr 19 2017 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 2.0.5-1
- Added timeout - Nethesis/dev#5031

* Mon Jan 23 2017 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 2.0.4-1
- facter: handled empty categories and products
- facter: add users fact. Nethesis/dev#5051

* Wed Nov 02 2016 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 2.0.3-1
- nethserver products: create cache for pkginfo compsdump errors. Nethesis/dev#5026

* Thu Oct 20 2016 Davide Principi <davide.principi@nethesis.it> - 2.0.2-1
- Gestire i prodotti nethesis nell'inventario e mostrarli su my - Nethesis/dev#5019

* Wed Oct 19 2016 Davide Principi <davide.principi@nethesis.it> - 2.0.1-1
- Fix bad encoding file opening of flashstart plugin

* Thu Sep 22 2016 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 2.0.0-1
- First NS 7 release

* Fri Jul 15 2016 Edoardo Spadoni <edoardo.spadoni@nethesis.it> - 1.0.1-1
- flashstart: read log from yesterday, avoid error if log file doesn not exists
- Add flashstart fact [US #238]

* Fri May 06 2016 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.0-1
- First public release [NH:4148]


