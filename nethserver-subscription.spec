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


%files -f %{name}-%{version}-filelist
%defattr(-,root,root)
%dir %{_nseventsdir}/%{name}-update

%changelog
