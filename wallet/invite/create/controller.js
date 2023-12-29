function openInvite($rootScope, domain, success) {
    window.$mdBottomSheet.show({
        templateUrl: "/wallet/invite/create/index.html",
        controller: function ($scope) {
            addFormats($scope)
            $scope.domain = domain
            if (DEBUG) {
                $scope.amount = 1
            }
            setFocus("invite_coins")
            $scope.create = function () {
                let invite_code = randomString(8)
                postContractWithGas(domain, contract.bonus_create, function (key, next_hash) {
                    return {
                        key: key,
                        next_hash: next_hash,
                        amount: $scope.amount,
                        invite_next_hash: md5(invite_code),
                    }
                }, function () {
                    openInviteCopy(domain,
                        invite_code,
                        success)
                })
            }
        }
    }).then(function () {
        if (success)
            success()
    })
}