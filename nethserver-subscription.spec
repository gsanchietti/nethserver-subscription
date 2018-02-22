Summary: NethServer Enterprise subscription
Name: nethserver-subscription
Version: 0.0.1
Release: 1%{?dist}
License: GPL
URL: %{url_prefix}/%{name}
Source0: %{name}-%{version}.tar.gz
BuildArch: noarch

Requires: nethserver-base

BuildRequires: perl
BuildRequires: nethserver-devtools


%package ui
Summary: Web Interface for subscription
Requires: %{name} = %{version}-%{release}
%description ui
%files ui -f %{name}-%{version}-filelist-ui


%description
NethServer Enterprise subscription

%prep
%setup

%build
perl createlinks

%install
rm -rf %{buildroot}
(cd root; find . -depth -print | cpio -dump %{buildroot})
%{genfilelist} %{buildroot} > %{name}-%{version}-filelist
echo "%doc COPYING" >> %{name}-%{version}-filelist
grep -e php$ -e rst$ -e html$ %{name}-%{version}-filelist > %{name}-%{version}-filelist-ui
grep -v /usr/share/nethesis/NethServer %{name}-%{version}-filelist > %{name}-%{version}-filelist-core

%files -f %{name}-%{version}-filelist-core
%defattr(-,root,root)
%dir %{_nseventsdir}/%{name}-update

%changelog
