function openOptionsDialog(domain, success) {
    window.$mdBottomSheet.show({
        templateUrl: '/wallet/options/index.html',
        locals: {
            domain: domain,
        },
        controller: function ($scope, $mdBottomSheet, locals) {
            $scope.locals = locals
            $scope.balance = 0
            var domain = locals.domain

            postContract(domain, data10.wallet, {
                address: wallet.username,
            }, function (response) {
                $scope.balance = response.amount
                $scope.$apply()
            })

            post("/wallet/api/contracts.php", {
                domain: domain,
            }, function (response) {
                $scope.contracts = response.contracts
                $scope.$apply()
            })

            $scope.sendDialog = function (domain) {
                openSendDialog(domain, success)
            }

            $scope.giveaway = function () {
                wallet.auth(function (username) {
                    postContract(domain, data10.drop, {
                        address: username
                    }, function () {
                        success()
                        $mdBottomSheet.hide()
                    })
                })
            }
        }
    })
}